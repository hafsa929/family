@extends('layouts.app')

@section('title', 'الفواتير')

@section('content')


<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg bg-gradient-dark">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center flex-wrap">

                        <div>
                            <h2 class="text-white fw-bold mb-1">
                                <i class="fas fa-wallet me-2"></i>
                                لوحة الحسابات المالية
                            </h2>

                            <p class="text-white opacity-8 mb-0">
                                إدارة المصروفات والمعاملات المالية
                            </p>
                        </div>

                        <div class="mt-3 mt-md-0">
                            <a href="#expenseModal"
                               class="btn bg-white text-dark fw-bold"
                               data-bs-toggle="modal"
                               data-bs-target="#expenseModal">

                                <i class="fas fa-plus-circle me-1"></i>
                                إضافة مصروف
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Statistics --}}
    <div class="row">

        <div class="col-xl-4 col-sm-6 mb-4">
            <div class="card shadow border-0 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-sm text-muted mb-1">إجمالي الإيرادات</p>
                            <h3 class="text-success fw-bold mb-0">
                                {{ number_format($totalRevenues,2) }} د.ل
                            </h3>
                        </div>

                        <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                            <i class="fas fa-arrow-up text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-sm-6 mb-4">
            <div class="card shadow border-0 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-sm text-muted mb-1">إجمالي المصروفات</p>
                            <h3 class="text-danger fw-bold mb-0">
                                {{ number_format($totalExpenses,2) }} د.ل
                            </h3>
                        </div>

                        <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                            <i class="fas fa-arrow-down text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-sm-12 mb-4">
            <div class="card shadow border-0 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-sm text-muted mb-1">الرصيد الحالي</p>
                            <h3 class="text-primary fw-bold mb-0">
                                {{ number_format($balance,2) }} د.ل
                            </h3>
                        </div>

                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="fas fa-wallet text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Content --}}
    <div class="row mt-4">

        <div class="col-lg-7 mb-4">
            <div class="card shadow-lg border-0">

                <div class="card-header pb-0 bg-white border-0">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-exchange-alt text-primary me-2"></i>
                        آخر المعاملات
                    </h5>
                </div>

                <div class="card-body pt-3">

                    @forelse($transactions as $transaction)

                        <div class="transaction-item p-3 mb-3 border-radius-lg">
                            <div class="d-flex justify-content-between align-items-center">

                                <div class="d-flex align-items-center">

                                    <div class="icon icon-shape
                                        {{ $transaction->type == 'deposit'
                                            ? 'bg-gradient-success'
                                            : 'bg-gradient-danger' }}
                                        shadow text-center border-radius-md me-3">

                                        <i class="fas
                                        {{ $transaction->type == 'withdraw'
                                            ? 'fa-arrow-up'
                                            : 'fa-arrow-down' }}
                                        text-white"></i>

                                    </div>

                                    <div>
                                        <h6 class="mb-1 fw-bold">
                                                {{ $transaction->description }}
                                            </h6>

                                            <div class="mb-1">
                                                <small class="text-primary fw-bold">
                                                    <i class="fas fa-user me-1"></i>
                                                    {{ $transaction->user->name ?? 'غير معروف' }}
                                                </small>
                                            </div>

                                            <small class="text-muted">
                                                {{ $transaction->created_at->format('Y-m-d h:i A') }}
                                            </small>
                                    </div>

                                </div>

                                <div>
                                    <h6 class="{{ $transaction->type == 'deposit' ? 'text-success' : 'text-danger' }} fw-bold mb-0">
                                        {{ $transaction->type == 'deposit' ? '+' : '-' }}
                                        {{ number_format($transaction->amount,2) }}
                                    </h6>
                                </div>

                            </div>
                        </div>

                    @empty
                        <div class="text-center py-5">
                            <h5>لا توجد معاملات</h5>
                        </div>
                    @endforelse

                </div>

            </div>
        </div>

        <div class="col-lg-5 mb-4">

            <div class="card shadow-lg border-0 h-100">

                <div class="card-header pb-0 bg-white border-0 d-flex justify-content-between">

                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-file-invoice-dollar text-danger me-2"></i>

                        آخر المصروفات
                    </h5>
                    <button onclick="printExpenses()" class="btn btn-sm btn-dark">
                        <i class="fas fa-print"></i>
                        طباعة
                    </button>
                </div>

                <div class="card-body pt-3" id="expenses-section">

                    @forelse($expenses as $expense)

                        <div class="card bg-gray-100 border-0 mb-3">
                            <div class="card-body py-3">

                                <div class="d-flex justify-content-between">

                                    <div>
                                        <h6 class="fw-bold mb-1">
                                            {{ $expense->reason }}
                                        </h6>

                                        <p class="text-sm text-muted mb-1">
                                            المستفيد:
                                            <span class="fw-bold">
                                                {{ $expense->beneficiary }}
                                            </span>
                                        </p>

                                        <small class="text-muted">
                                            {{ $expense->date }}
                                        </small>
                                    </div>

                                    <div>
                                        <span class="badge bg-gradient-danger">
                                            {{ number_format($expense->amount,2) }} د.ل
                                        </span>
                                    </div>

                                </div>

                            </div>
                        </div>

                    @empty
                        <div class="text-center py-5">
                            <h5>لا توجد مصروفات</h5>
                        </div>
                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>

{{-- Modal --}}
<div class="modal fade" id="expenseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="mb-0">إضافة مصروف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ url('/expenses/store') }}">
                @csrf

                <div class="modal-body">

                    <label>المبلغ</label>
                    <input type="number" name="amount" class="form-control mb-3" required>

                    <label>سبب المصروف</label>
                    <textarea name="reason" class="form-control mb-3" required></textarea>

                    <label>المستفيد</label>

                        <select name="beneficiary" class="form-control" required>

                            <option value="">
                                اختر العضو المستفيد
                            </option>

                            @foreach($users as $user)

                                <option value="{{ $user->name }}">

                                    {{ $user->name }}

                                </option>

                            @endforeach

                        </select>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        إلغاء
                    </button>

                    <button type="submit" class="btn btn-danger">
                        حفظ
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>
<style>

.hover-card{
    transition: .3s;
}

.hover-card:hover{
    transform: translateY(-5px);
}

.transaction-item{
    background: #f8f9fa;
    transition: .3s;
}

.transaction-item:hover{
    background: white;
    box-shadow: 0 5px 20px rgba(0,0,0,.08);
}

.bg-gradient-dark{
    background: linear-gradient(310deg,#141727,#3A416F);
}

.bg-gradient-success{
    background: linear-gradient(310deg,#17ad37,#98ec2d);
}

.bg-gradient-danger{
    background: linear-gradient(310deg,#ea0606,#ff667c);
}

.bg-gradient-primary{
    background: linear-gradient(310deg,#2152ff,#21d4fd);
}

</style>
<script>

function printExpenses() {

    let rows = '';

    @foreach($expenses as $expense)

        rows += `
            <tr>

                <td>{{ $expense->date }}</td>

                <td>
                    {{ $expense->user->name ?? '-' }}
                </td>

                <td>
                    {{ $expense->reason }}
                </td>

                <td>
                    {{ number_format($expense->amount,2) }} د.ل
                </td>

            </tr>
        `;

    @endforeach

    let total = "{{ number_format($totalExpenses,2) }}";

    let win = window.open('', '', 'width=1200,height=800');

    win.document.write(`

    <html dir="rtl">

    <head>

        <title>
            تقرير المصروفات
        </title>

        <style>

            body{

                font-family:Tahoma;
                padding:40px;
                color:#111;

            }

            .header{

                text-align:center;
                margin-bottom:30px;

            }

            .header h2{

                margin:0;
                font-size:28px;

            }

            .header p{

                color:#666;

            }

            table{

                width:100%;
                border-collapse:collapse;
                margin-top:20px;

            }

            table th{

                background:#111827;
                color:white;
                padding:14px;
                font-size:14px;

            }

            table td{

                border:1px solid #ddd;
                padding:12px;
                text-align:center;
                font-size:14px;

            }

            .total-box{

                margin-top:30px;
                text-align:left;

            }

            .total{

                display:inline-block;
                background:#dc3545;
                color:white;
                padding:12px 25px;
                border-radius:8px;
                font-size:18px;
                font-weight:bold;

            }

            .footer{

                margin-top:60px;
                display:flex;
                justify-content:space-between;

            }

            .signature{

                text-align:center;
                width:200px;

            }

            .line{

                border-top:1px solid #000;
                margin-top:60px;
                padding-top:8px;

            }

            @media print{

                body{
                    padding:20px;
                }

            }

        </style>

    </head>

    <body>

        <div class="header">

            <h2>
                تقرير المصروفات المالية
            </h2>

            <p>

                بتاريخ:
                ${new Date().toLocaleDateString()}

            </p>

        </div>

        <table>

            <thead>

                <tr>

                    <th>
                        التاريخ
                    </th>

                    <th>
                        المستفيد
                    </th>

                    <th>
                        سبب المصروف
                    </th>

                    <th>
                        المبلغ
                    </th>

                </tr>

            </thead>

            <tbody>

                ${rows}

            </tbody>

        </table>

        <div class="total-box">

            <div class="total">

                إجمالي المصروفات:
                ${total} د.ل

            </div>

        </div>

        <div class="footer">

           

        </div>

    </body>

    </html>

    `);

    win.document.close();

    win.print();
}

</script>
@endsection