<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>

        body{
            direction: rtl;
            font-family: Tahoma, Arial, sans-serif;
        }

        h3{
            text-align:center;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th,td{
            border:1px solid #000;
            padding:8px;
            text-align:center;
            vertical-align:middle;
        }

        thead{
            background:#f2f2f2;
        }

    </style>
</head>
<body>

<h3>
    تقرير اشتراكات شهر {{ $month }}
</h3>

<table>

    <thead>

    <tr>

        <th>الاسم</th>
        <th>المطلوب</th>
        <th>المدفوع</th>
        <th>المتبقي</th>
        <th>الحالة</th>

    </tr>

    </thead>

    <tbody>

    @foreach($contributions as $item)

        <tr>

            <td>{{ $item->user->name }}</td>

            <td>{{ $item->expected_amount }}</td>

            <td>{{ $item->paid_amount }}</td>

            <td>{{ $item->expected_amount - $item->paid_amount }}</td>

            <td>
                @if($item->status=='paid')
                    تم الدفع
                @elseif($item->status=='partial')
                    جزئي
                @else
                    غير مدفوع
                @endif
            </td>

        </tr>

    @endforeach
{{-- الإجمالي --}}
<tr style="font-weight:bold; background:#f2f2f2;">

    <td>الإجمالي</td>

    <td>
        {{ $contributions->sum('expected_amount') }}
    </td>

    <td>
        {{ $contributions->sum('paid_amount') }}
    </td>

    <td>
        {{ $contributions->sum('expected_amount') - $contributions->sum('paid_amount') }}
    </td>

    <td>-</td>

</tr>
    </tbody>

</table>

<script>
window.onload = function () {
    window.print();
}
</script>

</body>
</html>