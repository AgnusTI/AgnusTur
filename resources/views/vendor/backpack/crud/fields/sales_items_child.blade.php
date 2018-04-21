@extends('crud::fields.child')

@push('crud_fields_styles')

    <style>
        @if (Auth::user()->profile == App\Models\User::USER_PROFILE__ADMIN)
        @media screen and (max-width: 1600px) {
            .form-group.child-table-container .table-wrapper {
                overflow-x: scroll;
            }

            .form-group.child-table-container table {
                min-width: 1500px;
            }
        }
        @else
        @media screen and (max-width: 1230px) {
            .form-group.child-table-container .table-wrapper {
                overflow-x: scroll;
            }

            .form-group.child-table-container table {
                min-width: 1000px;
            }
        }
        @endif
    </style>
@endpush

@push('child_after_scripts')

<script>

    function changeIntegerValue(tr, inputName, value) {
        tr.find("input[ng-model='item." + inputName + "']").val(value);
        tr.find("input[ng-model='item." + inputName + "']").formatInteger();
        tr.find("input[ng-model='item." + inputName + "']").trigger('input');
    }

    function changeFloatValue(tr, inputName, value) {
        tr.find("input[ng-model='item." + inputName + "']").val(value);
        tr.find("input[ng-model='item." + inputName + "']").formatFloat();
        tr.find("input[ng-model='item." + inputName + "']").trigger('input');
    }

    function updateTotalItem(tr) {
        var item = tr.find(".child_select2_field[ng-model='item.item_id']");

        var selectedId = item.val();
        var vl_adult = item.find("option[value='" + selectedId + "']").attr("data-vl_adult");
        var vl_child = item.find("option[value='" + selectedId + "']").attr("data-vl_child");

        var vl_adult_expense = parseInt(item.find("option[value='" + selectedId + "']").attr("data-vl_adult_expense")) || 0;
        var vl_child_expense = parseInt(item.find("option[value='" + selectedId + "']").attr("data-vl_child_expense")) || 0;

        var adults = parseInt(tr.find("input[ng-model='item.adults']").val().replace(".", "")) || 0;
        var childs = parseInt(tr.find("input[ng-model='item.childs']").val().replace(".", "")) || 0;
        var vl_discount = parseInt(tr.find("input[ng-model='item.vl_discount']").val().replace(".", "")) || 0;

        var vl_subtotal = parseInt((vl_adult * adults) + (vl_child * childs)) || 0;
        var vl_expense = parseInt((vl_adult_expense * adults) + (vl_child_expense * childs)) || 0;

        changeIntegerValue(tr, 'vl_subtotal', vl_subtotal);

        var vl_total = parseInt(vl_subtotal - vl_discount) || 0;

        changeIntegerValue(tr, 'vl_total', vl_total);

        changeIntegerValue(tr, 'vl_expense', vl_expense);


        calculatePercentDiscountItem(tr);

        @if (Auth::user()->profile == App\Models\User::USER_PROFILE__ADMIN)
            calculateCommissionByPercent(tr);
            updatePartnerItem(tr);
        @endif

        updateTotal();
    }

    function calculateDiscountItem(tr) {
        var vl_subtotal = parseInt(tr.find("input[ng-model='item.vl_subtotal']").val().replace(".", "")) || 0;
        var vl_total = parseInt(tr.find("input[ng-model='item.vl_total']").val().replace(".", "")) || 0;
        var vl_discount = parseInt(vl_subtotal - vl_total) || 0;

        changeIntegerValue(tr, 'vl_discount', vl_discount);

        calculatePercentDiscountItem(tr);

        updateTotal();
    }

    function calculatePercentDiscountItem(tr) {
        var vl_subtotal = parseInt(tr.find("input[ng-model='item.vl_subtotal']").val().replace(".", "")) || 0;
        var vl_total = parseInt(tr.find("input[ng-model='item.vl_total']").val().replace(".", "")) || 0;
        var vl_discount = parseInt(vl_subtotal - vl_total) || 0;
        var vl_percent_discount = parseFloat(vl_discount * 100 / vl_subtotal) || 0;

        changeFloatValue(tr, 'vl_percent_discount', vl_percent_discount);

        @if (Auth::user()->profile == App\Models\User::USER_PROFILE__ADMIN)
        calculateCommissionByPercent(tr);
        updatePartnerItem(tr);
        @endif

        updateTotal();
    }



    function calculateDiscountByPercentItem(tr) {
        console.log('calculateDiscountByPercentItem');
        
        var vl_subtotal = parseInt(tr.find("input[ng-model='item.vl_subtotal']").val().replace(".", "")) || 0;
        var vl_percent_discount = parseFloat(tr.find("input[ng-model='item.vl_percent_discount']").val().replace(".", "").replace(",", ".")) || 0;
        var vl_discount = parseInt(vl_percent_discount * vl_subtotal / 100) || 0;
        var vl_total = parseInt(vl_subtotal - vl_discount) || 0;

        changeIntegerValue(tr, 'vl_discount', vl_discount);

        changeIntegerValue(tr, 'vl_total', vl_total);

        @if (Auth::user()->profile == App\Models\User::USER_PROFILE__ADMIN)
        calculateCommissionByPercent(tr);
        updatePartnerItem(tr);
        @endif

        updateTotal();
    }

    function updateTotal() {
        var vl_subtotal_sum = 0.00;
        $("input[ng-model='item.vl_subtotal']").each(function() {
            vl_subtotal_sum += parseInt($(this).val().replace(".", ""), 10);
        });

        var vl_discount_sum = 0.00;
        $("input[ng-model='item.vl_discount']").each(function() {
            vl_discount_sum += parseInt($(this).val().replace(".", ""), 10);
        });
        var vl_total_sum = 0.00;
        $("input[ng-model='item.vl_total']").each(function() {
            vl_total_sum += parseInt($(this).val().replace(".", ""), 10);
        });
        var vl_percent_discount_sum = parseFloat(vl_discount_sum * 100 / vl_subtotal_sum) || 0;



        $("#vl_subtotal").val(vl_subtotal_sum).formatInteger();
        $("#vl_discount").val(vl_discount_sum).formatInteger();
        $("#vl_percent_discount").val(vl_percent_discount_sum).formatFloat();
        $("#vl_total").val(vl_total_sum).formatInteger();

        updateRest();

        @if (Auth::user()->profile == App\Models\User::USER_PROFILE__ADMIN)

        var vl_expense_sum = 0;
        $("input[ng-model='item.vl_expense']").each(function() {
            vl_expense_sum += parseInt($(this).val().replace(".", ""), 10);
        });
        $("#vl_expense").val(vl_expense_sum).formatInteger();

        var vl_net_total = parseInt( vl_total_sum - vl_expense_sum ) || 0;
        $("#vl_net_total").val(vl_net_total).formatInteger();

        var vl_commission_sum = 0;
        $("input[ng-model='item.vl_commission']").each(function() {
            vl_commission_sum += parseInt($(this).val().replace(".", ""), 10);
        });
        $("#vl_commission").val(vl_commission_sum).formatInteger();

        var vl_percent_commission_sum = parseFloat(vl_commission_sum * 100 / vl_total_sum) || 0;
        $("#vl_percent_commission").val(vl_percent_commission_sum).formatFloat();

        @endif
    }

    function updateRest() {

        var vl_total = parseInt($("#vl_total").val().replace('.', '')) || 0;
        var vl_pay = parseInt($("#vl_pay").val().replace('.', '')) || 0;
        var vl_rest = parseInt(vl_total - vl_pay) || 0;

        $("#vl_rest").val(vl_rest).formatInteger();
    }

    $(function() {
        $("#vl_pay").focusout(function() {
            updateRest();
        });

        

        @if (Auth::user()->profile == App\Models\User::USER_PROFILE__ADMIN)
            /**
            *   ADMINISTRATOR
            */

            // $("#vl_expense").focusout(function() {
            //     var vl_total = parseInt($("#vl_total").val().replace('.', '')) || 0;
            //     var vl_expense = parseInt($("#vl_expense").val().replace('.', '')) || 0;
            //     var vl_net_total = parseInt( vl_total - vl_expense ) || 0;
            //
            //     $("#vl_net_total").val(vl_net_total).formatInteger();
            // });
            //
            // $("#vl_percent_commission").focusout(function() {
            //     var vl_total = parseInt($("#vl_net_total").val().replace('.', '')) || 0;
            //     var vl_percent_commission = parseFloat($("#vl_percent_commission").val().replace('.', '')) || 0;
            //     var vl_commission = parseInt(vl_percent_commission * vl_total / 100) || 0;
            //
            //     $("#vl_commission").val(vl_commission).formatInteger();
            // });
            //
            // $("#vl_commission").focusout(function() {
            //     var vl_total = parseInt($("#vl_net_total").val().replace('.', '')) || 0;
            //     var vl_commission = parseInt($("#vl_commission").val().replace('.', '')) || 0;
            //     var vl_percent_commission = parseFloat(vl_commission * 100 / vl_total) || 0;
            //
            //     $("#vl_percent_commission").val(vl_percent_commission).formatFloat();
            // });
            //

        @endif

    });

    @if (Auth::user()->profile == App\Models\User::USER_PROFILE__ADMIN)

    function calculateCommissionByPercent(tr) {
        var vl_total = parseInt(tr.find("input[ng-model='item.vl_total']").val().replace(".", "")) || 0;
        var vl_expense = parseInt(tr.find("input[ng-model='item.vl_expense']").val().replace(".", "")) || 0;
        var vl_percent_commission = parseFloat(tr.find("input[ng-model='item.vl_percent_commission']").val().replace(".", "").replace(",", ".")) || 0;
        var vl_commission = parseInt((vl_total - vl_expense) * vl_percent_commission / 100) || 0;

        changeIntegerValue(tr, 'vl_commission', vl_commission);

        updateTotal();
    }

    function updatePartnerItem(tr) {
        var item = tr.find(".child_select2_field[ng-model='item.partner_id']");

        var selectedId = item.val();
        var vl_percent_partner = parseInt(item.find("option[value='" + selectedId + "']").attr("data-vl_percent_partner")) || 0;
        var vl_total = parseInt(tr.find("input[ng-model='item.vl_total']").val().replace(".", "")) || 0;
        var vl_partner = parseInt(vl_total * vl_percent_partner / 100) || 0;

        changeIntegerValue(tr, 'vl_partner', vl_partner);

        updateTotal();
    }

    @endif


    window.angularApp.directive('postRender', function ($timeout) {
        return {
            link: function (scope, element, attr) {
                $timeout(function () {

                    $("input[ng-model='item.adults'], input[ng-model='item.childs']").each(function (i, obj) {
                        if (!$(obj).data("configured")) {
                            if ($(obj).val() === "undefined") {
                                $(obj).val("0");
                            }
                            $(obj).focusout(function() {
                                updateTotalItem($(this).closest('tr'));
                            });
                            $(obj).data("configured", true);
                        }
                    });

                    $("input[ng-model='item.vl_total']").each(function (i, obj) {
                        if ($(obj).val() === "undefined") {
                            $(obj).val("0");
                        }
                        $(obj).focusin(function() {
                            $(this).attr("focused", "true");
                        });
                        $(obj).focusout(function() {
                            calculateDiscountItem($(this).closest('tr'));
                        });
                        if (!$(obj).data("configured")) {
                            $(obj).data("configured", true);
                        }
                    });
                    $("input[ng-model='item.vl_subtotal']").each(function (i, obj) {
                        if ($(obj).val() === "undefined") {
                            $(obj).val("0");
                        }
                        if (!$(obj).data("configured")) {
                            $(obj).data("configured", true);
                        }
                    });
                    $("input[ng-model='item.vl_discount']").each(function (i, obj) {
                        if ($(obj).val() === "undefined") {
                            $(obj).val("0");
                        }
                        $(obj).focusout(function() {
                            updateTotalItem($(this).closest('tr'));
                        });
                        if (!$(obj).data("configured")) {
                            $(obj).data("configured", true);
                        }
                    });
                    $("input[ng-model='item.vl_percent_discount']").each(function (i, obj) {
                        if ($(obj).val() === "undefined") {
                            $(obj).val("0");
                        }
                        $(obj).focusout(function() {
                            calculateDiscountByPercentItem($(this).closest('tr'));
                        });
                        if (!$(obj).data("configured")) {
                            $(obj).data("configured", true);
                        }
                    });

                    @if (Auth::user()->profile == App\Models\User::USER_PROFILE__ADMIN)
                        $("input[ng-model='item.vl_percent_commission']").each(function (i, obj) {
                            if (!$(obj).data("configured")) {
                                if ($(obj).val() === "undefined") {
                                    $(obj).val("0");
                                }
                                $(obj).focusout(function() {
                                    calculateCommissionByPercent($(this).closest('tr'));
                                });
                                if (!$(obj).data("configured")) {
                                    $(obj).data("configured", true);
                                }
                            }
                        });
                        $("input[ng-model='item.vl_partner'], input[ng-model='item.vl_commission'], input[ng-model='item.vl_expense']").each(function (i, obj) {
                            if (!$(obj).data("configured")) {
                                if ($(obj).val() === "undefined") {
                                    $(obj).val("0");
                                }
                                if (!$(obj).data("configured")) {
                                    $(obj).data("configured", true);
                                }
                            }
                        });

                        $(".child_select2_field[ng-model='item.partner_id']").each(function (i, obj) {
                            if (!$(obj).data("on-select2-selecting")) {
                                $(obj).on('select2:select', function (e) {
                                    updatePartnerItem($(this).closest('tr'));
                                });
                                $(obj).data("on-select2-selecting", true);
                            }
                        });
                    @endif

                    $(".child_select2_field[ng-model='item.item_id']").each(function (i, obj) {
                        if (!$(obj).data("on-select2-selecting")) {
                            $(obj).on('select2:select', function (e) {
                                updateTotalItem($(this).closest('tr'));


                            });
                            $(obj).data("on-select2-selecting", true);
                        }
                    });


                });
            }
        };
    });

</script>

@endpush
