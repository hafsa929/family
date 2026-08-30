<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">

```
<style>

    @page {
        margin: 18mm 15mm 18mm 15mm;
    }

    body {
        font-family: dejavusans;
        direction: rtl;
        color: #1f2937;
        font-size: 12px;
        background: #ffffff;
    }

    * {
        box-sizing: border-box;
    }

    /* =========================
       HEADER
    ========================= */

    .header {
        width: 100%;
        border-bottom: 3px solid #1f2937;
        padding-bottom: 14px;
        margin-bottom: 20px;
    }

    .header-table {
        width: 100%;
        border-collapse: collapse;
    }

    .header-right {
        width: 65%;
        vertical-align: middle;
    }

    .header-left {
        width: 35%;
        text-align: left;
        vertical-align: middle;
    }

    .system-title {
        font-size: 21px;
        font-weight: bold;
        color: #111827;
        margin-bottom: 5px;
    }

    .report-title {
        font-size: 14px;
        color: #4b5563;
    }

    .report-date {
        font-size: 10px;
        color: #6b7280;
        margin-top: 6px;
    }

    .document-label {
        display: inline-block;
        border: 1px solid #374151;
        padding: 7px 15px;
        font-size: 11px;
        font-weight: bold;
        color: #374151;
    }

    /* =========================
       MEMBER INFORMATION
    ========================= */

    .section-title {
        font-size: 13px;
        font-weight: bold;
        color: #111827;
        border-right: 4px solid #374151;
        padding-right: 8px;
        margin-bottom: 10px;
    }

    .member-box {
        border: 1px solid #d1d5db;
        background: #f9fafb;
        margin-bottom: 18px;
    }

    .member-table {
        width: 100%;
        border-collapse: collapse;
    }

    .member-table td {
        padding: 10px 12px;
        border-bottom: 1px solid #e5e7eb;
    }

    .member-table tr:last-child td {
        border-bottom: none;
    }

    .label {
        color: #6b7280;
        font-size: 10px;
        display: block;
        margin-bottom: 3px;
    }

    .value {
        color: #111827;
        font-size: 12px;
        font-weight: bold;
    }

    /* =========================
       FINANCIAL SUMMARY
    ========================= */

    .summary-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 8px;
        margin: 0 -8px 18px -8px;
    }

    .summary-box {
        border: 1px solid #d1d5db;
        padding: 12px;
        text-align: center;
        background: #ffffff;
    }

    .summary-title {
        font-size: 10px;
        color: #6b7280;
        margin-bottom: 6px;
    }

    .summary-value {
        font-size: 16px;
        font-weight: bold;
        color: #111827;
    }

    .summary-unit {
        font-size: 9px;
        color: #6b7280;
    }

    /* =========================
       CONTRIBUTIONS TABLE
    ========================= */

    .statement-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 8px;
    }

    .statement-table th {
        background: #1f2937;
        color: #ffffff;
        font-size: 10px;
        font-weight: bold;
        padding: 9px 6px;
        border: 1px solid #1f2937;
    }

    .statement-table td {
        padding: 8px 6px;
        border: 1px solid #d1d5db;
        text-align: center;
        font-size: 10px;
    }

    .statement-table tr:nth-child(even) td {
        background: #f9fafb;
    }

    .amount {
        font-weight: bold;
    }

    /* =========================
       STATUS
    ========================= */

    .status {
        font-weight: bold;
        font-size: 10px;
    }

    .paid {
        color: #15803d;
    }

    .partial {
        color: #b45309;
    }

    .unpaid {
        color: #b91c1c;
    }

    /* =========================
       TOTALS
    ========================= */

    .totals {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .totals td {
        padding: 9px;
        border: 1px solid #d1d5db;
    }

    .totals-label {
        background: #f3f4f6;
        font-weight: bold;
    }

    .totals-value {
        text-align: center;
        font-weight: bold;
    }

    /* =========================
       TRANSACTIONS
    ========================= */

    .transactions {
        margin-top: 25px;
    }

    .transaction-table {
        width: 100%;
        border-collapse: collapse;
    }

    .transaction-table th {
        background: #374151;
        color: white;
        padding: 8px;
        font-size: 10px;
        border: 1px solid #374151;
    }

    .transaction-table td {
        padding: 8px;
        border: 1px solid #d1d5db;
        font-size: 9px;
        vertical-align: middle;
    }

    .transaction-date {
        width: 18%;
        text-align: center;
        color: #4b5563;
    }

    .transaction-method {
        width: 15%;
        text-align: center;
    }

    .transaction-amount {
        width: 15%;
        text-align: center;
        font-weight: bold;
    }

    .transaction-description {
        width: 52%;
    }

    .payment-method {
        font-weight: bold;
    }

    /* =========================
       FOOTER
    ========================= */

    .footer {
        margin-top: 30px;
        border-top: 1px solid #d1d5db;
        padding-top: 10px;
        text-align: center;
        color: #6b7280;
        font-size: 9px;
    }

    .no-print {
        display: none;
    }

</style>
```

</head>

<body>

```
{{-- =========================
     HEADER
========================= --}}

<div class="header">

    <table class="header-table">

        <tr>

            <td class="header-right">

                <div class="system-title">
                    كشف حساب العضو
                </div>

                <div class="report-title">
                    بيان تفصيلي للاشتراكات والحركة المالية
                </div>

                <div class="report-date">
                    تاريخ إصدار الكشف:
                    {{ now()->format('Y-m-d') }}
                </div>

            </td>

            <td class="header-left">

                <div class="document-label">
                    كشف مالي رسمي
                </div>

            </td>

        </tr>

    </table>

</div>


{{-- =========================
     MEMBER INFORMATION
========================= --}}

<div class="section-title">
    بيانات العضو
</div>

<div class="member-box">

    <table class="member-table">

        <tr>

            <td width="34%">

                <span class="label">
                    اسم العضو
                </span>

                <span class="value">
                    {{ $user->name }}
                </span>

            </td>

            <td width="33%">

                <span class="label">
                    رقم الهاتف
                </span>

                <span class="value">
                    {{ $user->phone ?? '-' }}
                </span>

            </td>

            <td width="33%">

                <span class="label">
                    حالة العضو
                </span>

                <span class="value">

                    @if($user->status == 'active')
                        نشط
                    @else
                        متوقف
                    @endif

                </span>

            </td>

        </tr>

        <tr>

            <td>

                <span class="label">
                    رقم الحساب المصرفي
                </span>

                <span class="value">
                    {{ $user->account_number ?? '-' }}
                </span>

            </td>

            <td>

                <span class="label">
                    اسم المصرف
                </span>

                <span class="value">
                    {{ $user->bank_name ?? '-' }}
                </span>

            </td>

            <td>

                <span class="label">
                    IBAN
                </span>

                <span class="value">
                    {{ $user->iban ?? '-' }}
                </span>

            </td>

        </tr>

    </table>

</div>


{{-- =========================
     FINANCIAL SUMMARY
========================= --}}

@php

    $totalExpected = $contributions->sum('expected_amount');

    $totalPaid = $contributions->sum('paid_amount');

    $totalRemaining = $totalExpected - $totalPaid;

@endphp

<div class="section-title">
    الملخص المالي
</div>

<table class="summary-table">

    <tr>

        <td width="33%">

            <div class="summary-box">

                <div class="summary-title">
                    إجمالي المطلوب
                </div>

                <div class="summary-value">
                    {{ number_format($totalExpected, 2) }}

                    <span class="summary-unit">
                        د.ل
                    </span>
                </div>

            </div>

        </td>

        <td width="33%">

            <div class="summary-box">

                <div class="summary-title">
                    إجمالي المدفوع
                </div>

                <div class="summary-value">
                    {{ number_format($totalPaid, 2) }}

                    <span class="summary-unit">
                        د.ل
                    </span>
                </div>

            </div>

        </td>

        <td width="33%">

            <div class="summary-box">

                <div class="summary-title">
                    إجمالي المتبقي
                </div>

                <div class="summary-value">
                    {{ number_format($totalRemaining, 2) }}

                    <span class="summary-unit">
                        د.ل
                    </span>
                </div>

            </div>

        </td>

    </tr>

</table>


{{-- =========================
     CONTRIBUTIONS
========================= --}}

<div class="section-title">
    تفاصيل الاشتراكات
</div>

<table class="statement-table">

    <thead>

        <tr>

            <th width="20%">
                الشهر
            </th>

            <th width="20%">
                المبلغ المطلوب
            </th>

            <th width="20%">
                المبلغ المدفوع
            </th>

            <th width="20%">
                المتبقي
            </th>

            <th width="20%">
                الحالة
            </th>

        </tr>

    </thead>

    <tbody>

        @forelse($contributions as $item)

            @php
                $remaining =
                    $item->expected_amount -
                    $item->paid_amount;
            @endphp

            <tr>

                <td>
                    {{ $item->month }}
                </td>

                <td class="amount">
                    {{ number_format($item->expected_amount, 2) }}
                    د.ل
                </td>

                <td class="amount">
                    {{ number_format($item->paid_amount, 2) }}
                    د.ل
                </td>

                <td class="amount">
                    {{ number_format($remaining, 2) }}
                    د.ل
                </td>

                <td>

                    @if($item->status == 'paid')

                        <span class="status paid">
                            مدفوع بالكامل
                        </span>

                    @elseif($item->status == 'partial')

                        <span class="status partial">
                            مدفوع جزئيًا
                        </span>

                    @else

                        <span class="status unpaid">
                            غير مدفوع
                        </span>

                    @endif

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="5">
                    لا توجد اشتراكات مسجلة لهذا العضو.
                </td>

            </tr>

        @endforelse

    </tbody>

</table>


{{-- =========================
     TOTALS
========================= --}}

<table class="totals">

    <tr>

        <td width="25%" class="totals-label">
            إجمالي المطلوب
        </td>

        <td width="25%" class="totals-value">
            {{ number_format($totalExpected, 2) }}
            د.ل
        </td>

        <td width="25%" class="totals-label">
            إجمالي المدفوع
        </td>

        <td width="25%" class="totals-value">
            {{ number_format($totalPaid, 2) }}
            د.ل
        </td>

    </tr>

    <tr>

        <td class="totals-label">
            إجمالي المتبقي
        </td>

        <td colspan="3" class="totals-value">
            {{ number_format($totalRemaining, 2) }}
            د.ل
        </td>

    </tr>

</table>


{{-- =========================
     TRANSACTIONS
========================= --}}

<div class="transactions">

    <div class="section-title">
        الحركة المالية
    </div>

    <table class="transaction-table">

        <thead>

            <tr>

                <th class="transaction-date">
                    التاريخ
                </th>

                <th class="transaction-method">
                    طريقة الدفع
                </th>

                <th class="transaction-amount">
                    المبلغ
                </th>

                <th class="transaction-description">
                    البيان
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($transactions as $transaction)

                <tr>

                    <td class="transaction-date">
                        {{ $transaction->created_at->format('Y-m-d H:i') }}
                    </td>

                    <td class="transaction-method">

                        <span class="payment-method">

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

                    </td>

                    <td class="transaction-amount">

                        {{ number_format($transaction->amount, 2) }}
                        د.ل

                    </td>

                    <td class="transaction-description">

                        {{ $transaction->description ?? '-' }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4" style="text-align:center;">

                        لا توجد عمليات مالية مسجلة.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>


{{-- =========================
     FOOTER
========================= --}}

<div class="footer">

    هذا الكشف صادر من النظام ويحتوي على البيانات المالية المسجلة للعضو.

    <br>

    كشف حساب — {{ $user->name }}

</div>
```

</body>

</html>
