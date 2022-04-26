<!doctype html>
<html lang="en">
  <head>
    <title>Hello, world!</title>
  </head>
  <body>
        <table>
            <thead>
                <tr>
                    @foreach ($headings as $heading)
                        <th style="font-size: 10px">{{Str::of($heading)->headline()}}</th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $row)
                    <tr>
                        @foreach ($exportObject?$exportObject->map($row):$row as $column)
                            @if (is_numeric($column) || is_string($column))
                                <td style="font-size: 10px">{!!$column!!}</td>
                            @else
                                <td style="font-size: 10px">Not Printable</td>
                            @endif

                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
  </body>
</html>
