$().ready(function() {
    $.validator.addMethod("validateEmail", function(value, element) {
        return this.optional(element) || /^\S+@\S+\.\S+$/i.test(value);
    });

    $.validator.addMethod("validatePhone", function(value, element) {
        return this.optional(element) || /^([0-9\(\)\/\+ \-]*)$/i.test(value);
    });

    // validate address
    $("#addressForm").validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            city: {
                required: true
            },
            province: {
                required: true
            },
            wards: {
                required: true
            }
        },
        messages: {
            city: {
                required: "Bắt buộc chọn thành phố"
            },
            province: {
                required: "Bắt buộc chọn quận huyện"
            },
            wards: {
                required: "Bắt buộc chọn xã phường"
            }
        }
    });

    $("#billForm").validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            shipping_email: {
                required: true,
                validateEmail: true
            },
            shipping_name: {
                required: true
            },
            shipping_address: {
                required: true
            },
            shipping_phone: {
                required: true,
                validatePhone: true
            },
            shipping_notes: {
                required: true
            }
        },
        messages: {
            shipping_email: {
                required: "Bắt buộc nhập email",
                validateEmail: "Email không hợp lệ"
            },
            shipping_name: {
                required: "Bắt buộc nhập tên"
            },
            shipping_address: {
                required: "Bắt buộc nhập địa chỉ giao hàng"
            },
            shipping_phone: {
                required: "Bắt buộc nhập số điện thoại",
                validatePhone: "Số điện thoại không hợp lệ"
            },
            shipping_notes: {
                required: "Bắt buộc nhập ghi chú"
            }
        }
    });

    // validate discount
    $("#couponForm").validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        rules: {
            coupon: {
                required: true
            }
        }
    });

    $(".send_order").click(function(e) {
        if ($("#billForm").valid()) {
            swal(
                {
                    title: "Xác nhận đơn hàng",
                    text:
                        "Đơn hàng sẽ không được hoàn trả khi đặt,bạn có muốn đặt không?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Cảm ơn, Mua hàng",

                    cancelButtonText: "Đóng,chưa mua",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        var shipping_email = $(".shipping_email").val();
                        var shipping_name = $(".shipping_name").val();
                        var shipping_address = $(".shipping_address").val();
                        var shipping_phone = $(".shipping_phone").val();
                        var shipping_notes = $(".shipping_notes").val();
                        var shipping_method = $(".payment_select").val();
                        var order_fee = $(".order_fee").val();
                        var order_coupon = $(".order_coupon").val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url: "/confirm-order",
                            method: "POST",
                            data: {
                                shipping_email: shipping_email,
                                shipping_name: shipping_name,
                                shipping_address: shipping_address,
                                shipping_phone: shipping_phone,
                                shipping_notes: shipping_notes,
                                _token: _token,
                                order_fee: order_fee,
                                order_coupon: order_coupon,
                                shipping_method: shipping_method
                            },
                            success: function() {
                                swal(
                                    "Đơn hàng",
                                    "Đơn hàng của bạn đã được gửi thành công",
                                    "success"
                                );
                                window.setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            },
                            error: function($err) {
                                swal(
                                    "Đơn hàng",
                                    "Đặt hàng không thành công!",
                                    "error"
                                );
                            }
                        });
                    } else {
                        swal(
                            "Đóng",
                            "Đơn hàng chưa được gửi, vui lòng hoàn tất đơn hàng",
                            "error"
                        );
                    }
                }
            );
        }
    });

    $(".calculate_delivery").click(function(e) {
        $("#addressForm").validate({
            onfocusout: false,
            onkeyup: false,
            onclick: false,
            rules: {
                city: {
                    required: true
                },
                province: {
                    required: true
                },
                wards: {
                    required: true
                }
            },
            messages: {
                city: {
                    required: "Bắt buộc chọn thành phố"
                },
                province: {
                    required: "Bắt buộc chọn quận huyện"
                },
                wards: {
                    required: "Bắt buộc chọn xã phường"
                }
            }
        });
        if ($("#addressForm").valid()) {
            var matp = $(".city").val();
            var maqh = $(".province").val();
            var xaid = $(".wards").val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "/calculate-fee",
                method: "POST",
                data: {
                    matp: matp,
                    maqh: maqh,
                    xaid: xaid,
                    _token: _token
                },
                success: function() {
                    location.reload();
                }
            });
        }
    });
});
