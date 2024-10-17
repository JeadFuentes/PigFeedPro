<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PigFeedPro</title>
    <style>
      .content-info {
          background: #f9f9f9;
          padding: 40px 0;
          background-size: cover!important;
          background-position: top center!important;
          background-repeat: no-repeat!important;
          position: relative;
        padding-bottom:100px;
      }

      table {
          width: 100%;
          background: #fff;
          border: 1px solid #dedede;
      }

      table thead tr th {
          padding: 20px;
          border: 1px solid #dedede;
          color: #000;
      }

      table.table-striped tbody tr:nth-of-type(odd) {
          background: #f9f9f9;
      }

      table.result-point tr td.number {
          width: 100px;
          position: relative;
      } 

      .text-left {
          text-align: left!important;
      }

      table tr td {
          padding: 10px 20px;
          border: 1px solid #dedede;
      }
      table.result-point tr td .fa.fa-caret-up {
          color: green;
      }

      table.result-point tr td .fa {
          font-size: 20px;
          position: absolute;
          right: 20px;
      }

      table tr td {
          padding: 10px 40px;
          border: 1px solid #dedede;
      }

      table tr td img {
          max-width: 32px;
          float: left;
          margin-right: 11px;
          margin-top: 1px;
          border: 1px solid #dedede;
      }

      .row{
        --bs-gutter-x: 1.5rem;
          --bs-gutter-y: 0;
          display: flex;
          flex-wrap: wrap;
          margin-top: calc(-1 * var(--bs-gutter-y));
          margin-right: calc(-0.5 * var(--bs-gutter-x));
          margin-left: calc(-0.5 * var(--bs-gutter-x));
      }
    </style>
</head>
<body style="margin:0;padding:0;">
    <div class="text-center" style="text-align:center; padding-top:0; margin-top:0;">
      <div>
        <h1>FEED CONSUMPTION REPORT</h1>
        <p>From {{$pdfdata['startDate']}} to {{$pdfdata['endDate']}}</p>
      </div>
      <div class="container text-center">
        <div class="row" style="  ">
          <div class="col" style="flex: 1 0 0%;">
              <table class="table-striped table-responsive table-hover result-point">
                <thead class="point-table-head">
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">DESC</th>
                    <th class="text-center">UNIT/kg</th>
                    <th class="text-center">FEED TIME</th>
                    <th class="text-center">STATUS</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  @foreach ($pdfdata['data'] as $res)
                    <tr>
                        <td>{{$res['id']}}</td>
                        <td>{{$res['desc']}}</td>
                        <td>{{$res['unit']}}</td>
                        <td>{{$res['time']}}</td>
                        <td>{{$res['status']}}</td>
                    </tr>
                  @endforeach
                  <tr>
                    <th><h3>TOTAL</h3></th>
                    <th></th>
                    <th><h3>{{$pdfdata['total'];}} kg</h3></th>
                  </tr>
                </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
</body>
</html>