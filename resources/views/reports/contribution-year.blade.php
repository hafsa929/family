<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقرير اشتراكات سنة {{ $year }}</title>
</head>

<body>

<h2 style="text-align:center">
    تقرير الاشتراكات لسنة {{ $year }}
</h2>

<table border="1" width="100%" cellspacing="0" cellpadding="8">

<tr>
    <th>المشترك</th>
    <th>الشهر</th>
    <th>المبلغ المتوقع</th>
    <th>المبلغ المدفوع</th>
    <th>الحالة</th>
</tr>


@foreach($contributions as $item)

<tr>
    <td>{{ $item->user->name }}</td>
    <td>{{ $item->month }}</td>
    <td>{{ $item->expected_amount }}</td>
    <td>{{ $item->paid_amount }}</td>

    <td>
        @if($item->status == 'paid')
            تم الدفع
        @elseif($item->status == 'partial')
            جزئي
        @else
            غير مدفوع
        @endif
    </td>

</tr>

@endforeach

</table>
<script>
window.onload = function () {
    window.print();
}
</script>
</body>
</html>