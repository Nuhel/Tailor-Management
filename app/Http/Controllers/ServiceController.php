<?php

namespace App\Http\Controllers;

use App\DataTables\ServiceDataTable;
use App\Models\Service;
use App\Models\ServiceDesign;
use App\Models\ServiceDesignStyle;
use App\Models\ServiceMeasurement;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mavinoo\Batch\BatchFacade as Batch;

class ServiceController extends Controller
{

    public function index(ServiceDataTable $dataTable)
    {
        return $dataTable->render('components.datatable.index',['heading'=>'Servvices']);

    }


    public function create()
    {
        return view('service.create');
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:100",
            "crafting_price" => "required|numeric",
            "measurement" => "required|array",
            "measurement.*.name" => "required|string",
            "design" => "required|array",
            "design.*.name" => "required|string",
            "design.*.style" => "required|array",
            "design.*.style.*.name" => "required|string",
        ],[
            "measurement.*.name.required"=>"Measurement name is required",
            "design.*.name.required"=>"Design name is required",
            "design.*.style.*.name.required"=>"Style name is required",
        ]);

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withInput()
            ->withErrors($validator->errors());
        }
        try {
            DB::beginTransaction();
            $service = new Service();
            $service->name = $request->name;
            $service->crafting_price = $request->crafting_price;
            $service->save();
            $measurementNames = Arr::pluck($request->measurement, 'name');

            $measurements = collect($measurementNames)->map(function($value){
                $serviceMeasurement = new ServiceMeasurement();
                $serviceMeasurement->name = $value;
                return $serviceMeasurement;
            });

            $service->measurements()->saveMany($measurements);

            $designNames = Arr::pluck($request->design, 'name');
            $styles = Arr::pluck($request->design, 'style');

            foreach($designNames as $index => $designName){
                $serviceDesign = new ServiceDesign();
                $serviceDesign->name = $designName;
                $serviceDesign->service_id = $service->id;
                $serviceDesign->save();

                $serviceDesignStyle = collect($styles[$index])->map(function($value){
                    $serviceDesignStyle = new ServiceDesignStyle();
                    $serviceDesignStyle->name = $value['name'];
                    return $serviceDesignStyle;
                });
                $serviceDesign->styles()->saveMany($serviceDesignStyle);
            }
            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            return redirect()->back()->withInput();
        }
        return $this->redirectWithAlert(true, 'services');

    }

    public function show(Service $service){
        $service = $service->load('measurements')->load('designs.styles');
        return view('service.show')->with('service',$service);
    }

    public function edit(Service $service)
    {
        $service = $service->load('measurements')->load('designs.styles');
        return view('service.edit')->with('service',$service);
    }

    public function update(Request $request, Service $service)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:100",
            "crafting_price" => "required|numeric",
            "measurement" => "required|array",
            "measurement.*.name" => "required|string",
            "design" => "required|array",
            "design.*.name" => "required|string",
            "design.*.style" => "required|array",
            "design.*.style.*.name" => "required|string",
        ],[
            "measurement.*.name.required"=>"Measurement name is required",
            "design.*.name.required"=>"Design name is required",
            "design.*.style.*.name.required"=>"Style name is required",
        ]);

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withInput()
            ->withErrors($validator->errors());
        }

        try {
            $service->name = $request->name;
            $service->crafting_price = $request->crafting_price;
            $service->update();
            $this->handelMeasurementUpdate($request,$service);
            $this->handelDesignUpdate($request,$service);
            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            return redirect()->back()->withInput();
        }
        return $this->redirectWithAlert(true, 'services');
    }

    public function handelMeasurementUpdate(Request $request,Service $service){
        $measurementNames = Arr::pluck($request->measurement, 'name');
        $measurementIds = Arr::pluck($request->measurement, 'id');


        //Start Handel Measurements that should be deleted
        $service->load(['measurements' => function ($query) use ($measurementIds) {
            $query->whereNotIn('id', $measurementIds);
        }]);
        ServiceMeasurement::destroy($service->measurements->pluck('id')->toArray());
        //End Handel Measurements that should be deleted

        //Start Handle new measurements and add to db
        $insertableIndex= Arr::where($measurementIds, function ($value, $key) {
            return $value == null;
        });

        $insertableMeasurementNames= Arr::where($measurementNames, function ($value, $key) use($insertableIndex) {
            return Arr::exists($insertableIndex,$key);
        });
        $measurements = collect($insertableMeasurementNames)->map(function($value){
            $serviceMeasurement = new ServiceMeasurement();
            $serviceMeasurement->name = $value;
            return $serviceMeasurement;
        });
        if($measurements != null && count($measurements)){
            $service->measurements()->saveMany($measurements);
        }
        //End Handle new measurements and add to db

        //Start Handel Measurements that should be updated
        $updateableIds = Arr::where($measurementIds, function ($value, $key) {
            return $value != null;
        });
        $updateableMeasurementNames= Arr::where($measurementNames, function ($value, $key) use($updateableIds) {
            return Arr::exists($updateableIds,$key);
        });
        $updateableMeasurement = [];
        foreach($updateableIds as $index => $id){
            $updateableMeasurement[] = [
                'id' => $id,
                'name' => $updateableMeasurementNames[$index],
            ];
        }

        Batch::update(new ServiceMeasurement(), $updateableMeasurement, 'id');
        //End Handel Measurements that should be updated


    }

    public function handelDesignUpdate(Request $request,Service $service){
        $designNames = Arr::pluck($request->design, 'name');
        $designIds = Arr::pluck($request->design, 'id');
        $styles = Arr::pluck($request->design, 'style');


        //Start Handeling Deleted Design
        $updateableIndex= Arr::where($designIds, function ($value, $key) {
            return $value != null;
        });
        $deleteableDesign = ServiceDesign::where('service_id', $service->id)->whereNotIn('id',Arr::divide($updateableIndex)[1])->get();
        foreach($deleteableDesign as $design){
            $design->styles()->delete();
        }
        ServiceDesign::destroy($deleteableDesign->pluck('id')->toArray());
        //End Handeling Deleted Design

        //Start Handeling New Design
        $insertableIndex= Arr::where($designIds, function ($value, $key) {
            return $value == null;
        });


        foreach($insertableIndex as $index => $value){
            $serviceDesign = new ServiceDesign();
            $serviceDesign->name = $designNames[$index];
            $serviceDesign->service_id = $service->id;
            $serviceDesign->save();

            $serviceDesignStyle = collect($styles[$index])->map(function($value){
                $serviceDesignStyle = new ServiceDesignStyle();
                $serviceDesignStyle->name = $value['name'];
                return $serviceDesignStyle;
            });
            $serviceDesign->styles()->saveMany($serviceDesignStyle);
        }


        //End Handeling New Design

        //Start Handeling Updateable Design
        $updateableDesign = ServiceDesign::where('service_id', $service->id)->whereIn('id',Arr::divide($updateableIndex)[1])->get();

        foreach($updateableIndex as $index => $id){
            $serviceDesign =  ($updateableDesign->find($id));
            $serviceDesign->name = $designNames[$index];
            $serviceDesign->update();
            $this->handelStyleUpdate($styles[$index], $serviceDesign);

        }
        //End Handeling Updateable Design

    }


    public function handelStyleUpdate(Array $style,ServiceDesign $serviceDesign){
        $styleNames = Arr::pluck($style, 'name');
        $styleIds = Arr::pluck($style, 'id');


        //Start Handel Measurements that should be deleted
        $serviceDesign->load(['styles' => function ($query) use ($styleIds) {
            $query->whereNotIn('id', $styleIds);
        }]);
        ServiceDesignStyle::destroy($serviceDesign->styles->pluck('id')->toArray());
        //End Handel Measurements that should be deleted



        //Start Handle Styles measurements and add to db
        $insertableIndex= Arr::where($styleIds, function ($value, $key) {
            return $value == null;
        });

        $insertableStyletNames= Arr::where($styleNames, function ($value, $key) use($insertableIndex) {
            return Arr::exists($insertableIndex,$key);
        });
        $insertableStyles = collect($insertableStyletNames)->map(function($value){
            $serviceDesignStyle = new ServiceDesignStyle();
            $serviceDesignStyle->name = $value;
            return $serviceDesignStyle;
        });
        if($insertableStyles != null && count($insertableStyles)){
            $serviceDesign->styles()->saveMany($insertableStyles);
        }


        //End Handle new Styles and add to db

        //Start Handel Measurements that should be updated
        $updateableIds = Arr::where($styleIds, function ($value, $key) {
            return $value != null;
        });



        $updateableStyle = [];
        foreach($updateableIds as $index => $id){
            $updateableStyle[] = [
                'id' => $id,
                'name' => $styleNames[$index],
            ];
        }

        Batch::update(new ServiceDesignStyle(), $updateableStyle, 'id');
        //End Handel Measurements that should be updated


    }

    public function destroy(Service $service)
    {
        try{
            DB::beginTransaction();
            $service->measurements()->delete();
            foreach($service->designs as $design){
                $design->styles()->delete();
            }
            $service->designs()->delete();
            $service->delete();
            DB::commit();
            return $this->redirectWithAlert(true, 'services');
        }catch(\Exception $e){
            DB::rollBack();
            return $this->redirectWithAlert(false, 'services');
        }
    }
}
