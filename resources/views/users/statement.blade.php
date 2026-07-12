<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <title>كشف حساب العضو</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#f5f5f5;
            font-family: Tahoma;
        }

        .print-container{
            background:white;
            padding:40px;
            margin:30px auto;
            border-radius:15px;
            max-width:1000px;
        }

        .table th{
            background:#111827;
            color:white;
        }

        .status-paid{
            color:green;
            font-weight:bold;
        }

        .status-partial{
            color:orange;
            font-weight:bold;
        }

        .status-unpaid{
            color:red;
            font-weight:bold;
        }

        @media print {

            .no-print{
                display:none;
            }

            body{
                background:white;
            }

            .print-container{
                box-shadow:none;
                margin:0;
            }

        }

    </style>

</head>

<body>

<div class="print-container">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold">
                كشف حساب العضو
            </h3>

            <p class="text-muted">
                رحلة الدفع الكاملة
            </p>

        </div>

        <button onclick="window.print()" class="btn btn-dark no-print">

            طباعة

        </button>

    </div>

    {{-- معلومات العضو --}}
    <div class="card mb-4 border-0 shadow-sm">

        <div class="card-body">

            <div class="row">

                <div class="col-md-4">
                    <strong>الاسم:</strong>
                    {{ $user->name }}
                </div>

                <div class="col-md-4">
                    <strong>رقم الهاتف:</strong>
                    {{ $user->phone }}
                </div>

                <div class="col-md-4">
                    <strong>الحالة:</strong>

                    @if($user->status == 'active')

                        <span class="text-success">
                            نشط
                        </span>

                    @else

                        <span class="text-danger">
                            متوقف
                        </span>

                    @endif

                </div>

            </div>

        </div>

    </div>

    {{-- جدول الدفع --}}
    <table class="table table-bordered text-center align-middle">

        <thead>

            <tr>

                <th>الشهر</th>
                <th>المبلغ المطلوب</th>
                <th>المبلغ المدفوع</th>
                <th>المتبقي</th>
                <th>الحالة</th>

            </tr>

        </thead>

        <tbody>

            @foreach($contributions as $item)

            <tr>

                <td>{{ $item->month }}</td>

                <td>
                    {{ $item->expected_amount }}
                    د.ل
                </td>

                <td>
                    {{ $item->paid_amount }}
                    د.ل
                </td>

                <td>

                    {{ $item->expected_amount - $item->paid_amount }}

                    د.ل

                </td>

                <td>

                    @if($item->status == 'paid')

                        <span class="status-paid">
                            مدفوع
                        </span>

                    @elseif($item->status == 'partial')

                        <span class="status-partial">
                            جزئي
                        </span>

                    @else

                        <span class="status-unpaid">
                            غير مدفوع
                        </span>

                    @endif

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

    {{-- ملاحظات --}}
   <div class="mt-5">

    <h5 class="fw-bold mb-3">
        الملاحظات والحركة المالية
    </h5>

    @forelse($transactions as $transaction)

        
            <div class="card mb-2 border-0 shadow-sm">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <div class="mb-1">

                            {{ $transaction->description }}

                        </div>

                        <div>

                            <span class="badge bg-dark">

                                @if($transaction->payment_method == 'cash')

                                    كاش

                                @elseif($transaction->payment_method == 'bank')

                                    تحويل مصرفي

                                @elseif($transaction->payment_method == 'wallet')

                                    محفظة

                                @else

                                    غير محدد

                                @endif

                            </span>

                        </div>

                    </div>

                    <small class="text-muted">

                        {{ $transaction->created_at->format('Y-m-d H:i') }}

                    </small>

                </div>

            </div>

        </div>


    @empty

        <div class="alert alert-secondary">

            لا توجد ملاحظات أو عمليات دفع.

        </div>

    @endforelse

</div>

</div>

</body>
</html>