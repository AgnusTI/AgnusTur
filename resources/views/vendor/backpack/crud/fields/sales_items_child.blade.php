@extends('crud::fields.child')

@push('child_after_scripts')

<script>

    function updateTotalItem(tr) {
        var item = tr.find(".child_select2_field[ng-model='item.item_id']");

        var selectedId = item.val();
        var vl_adult = item.find("option[value='" + selectedId + "']").attr("data-vl_adult");
        var vl_child = item.find("option[value='" + selectedId + "']").attr("data-vl_child");

        var adults = parseInt(tr.find("input[ng-model='item.adults']").val().replace(".", "")) || 0;
        var childs = parseInt(tr.find("input[ng-model='item.childs']").val().replace(".", "")) || 0;
        var vl_discount = parseInt(tr.find("input[ng-model='item.vl_discount']").val().replace(".", "")) || 0;

        var vl_subtotal = parseInt((vl_adult * adults) + (vl_child * childs)) || 0;

        tr.find("input[ng-model='item.vl_subtotal']").val(vl_subtotal);
        tr.find("input[ng-model='item.vl_subtotal']").formatInteger();
        tr.find("input[ng-model='item.vl_subtotal']").trigger('input');

        var vl_total = parseInt(vl_subtotal - vl_discount) || 0;

        tr.find("input[ng-model='item.vl_total']").val(vl_total);
        tr.find("input[ng-model='item.vl_total']").formatInteger();
        tr.find("input[ng-model='item.vl_total']").trigger('input');

        calculatePercentDiscountItem(tr);

        updateTotal();
    }

    function calculateDiscountItem(tr) {
        var vl_subtotal = parseInt(tr.find("input[ng-model='item.vl_subtotal']").val().replace(".", "")) || 0;
        var vl_total = parseInt(tr.find("input[ng-model='item.vl_total']").val().replace(".", "")) || 0;
        var vl_discount = parseInt(vl_subtotal - vl_total) || 0;

        tr.find("input[ng-model='item.vl_discount']").val(vl_discount);
        tr.find("input[ng-model='item.vl_discount']").formatInteger();
        tr.find("input[ng-model='item.vl_discount']").trigger('input');

        calculatePercentDiscountItem(tr);

        updateTotal();
    }

    function calculatePercentDiscountItem(tr) {
        var vl_subtotal = parseInt(tr.find("input[ng-model='item.vl_subtotal']").val().replace(".", "")) || 0;
        var vl_total = parseInt(tr.find("input[ng-model='item.vl_total']").val().replace(".", "")) || 0;
        var vl_discount = parseInt(vl_subtotal - vl_total) || 0;
        var vl_percent_discount = parseInt(vl_discount * 100 / vl_subtotal) || 0;

        tr.find("input[ng-model='item.vl_percent_discount']").val(vl_percent_discount);
        tr.find("input[ng-model='item.vl_percent_discount']").formatInteger();
        tr.find("input[ng-model='item.vl_percent_discount']").trigger('input');

        updateTotal();
    }





    function calculateDiscountByPercentItem(tr) {
        var vl_subtotal = parseInt(tr.find("input[ng-model='item.vl_subtotal']").val().replace(".", "")) || 0;
        var vl_percent_discount = parseInt(tr.find("input[ng-model='item.vl_percent_discount']").val().replace(".", "")) || 0;
        var vl_discount = parseInt(vl_percent_discount * vl_subtotal / 100) || 0;
        var vl_total = parseInt(vl_subtotal - vl_discount) || 0;

        tr.find("input[ng-model='item.vl_discount']").val(vl_discount);
        tr.find("input[ng-model='item.vl_discount']").formatInteger();
        tr.find("input[ng-model='item.vl_discount']").trigger('input');

        tr.find("input[ng-model='item.vl_total']").val(vl_total);
        tr.find("input[ng-model='item.vl_total']").formatInteger();
        tr.find("input[ng-model='item.vl_total']").trigger('input');

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
        var vl_percent_discount_sum = parseInt(vl_discount_sum * 100 / vl_subtotal_sum) || 0;

        $("#vl_subtotal").val(vl_subtotal_sum).formatInteger();
        $("#vl_discount").val(vl_discount_sum).formatInteger();
        $("#vl_percent_discount").val(vl_percent_discount_sum).formatInteger();
        $("#vl_total").val(vl_total_sum).formatInteger();

        updateRest();
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

        $("#vl_percent_commission").focusout(function() {
            var vl_total = parseInt($("#vl_total").val().replace('.', '')) || 0;
            var vl_percent_commission = parseInt($("#vl_percent_commission").val().replace('.', '')) || 0;
            var vl_commission = parseInt(vl_percent_commission * vl_total / 100) || 0;

            $("#vl_commission").val(vl_commission).formatInteger();
        });

        $("#vl_commission").focusout(function() {
            var vl_total = parseInt($("#vl_total").val().replace('.', '')) || 0;
            var vl_commission = parseInt($("#vl_commission").val().replace('.', '')) || 0;
            var vl_percent_commission = parseInt(vl_commission * 100 / vl_total) || 0;

            $("#vl_percent_commission").val(vl_percent_commission).formatInteger();
        });

        @endif

    });




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
