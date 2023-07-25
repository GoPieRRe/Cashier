$(function () {
    $("#button-plus").on("click", function () {
        const productId = $(this).data("product");
        changeCartQuantity(productId, "increment");
    });

    $("#button-minus").on("click", function () {
        const productId = $(this).data("product");
        changeCartQuantity(productId, "decrement");
    });

    function changeCartQuantity(productId, action) {
        // Implement an AJAX call to send the request to the server
        // and update the cart quantity in the backend.
        // For simplicity, I'll use a basic jQuery AJAX request here.
        $.ajax({
            url: `/cart/${action}`,
            type: "POST",
            data: { product_id: productId, _token: "{{ csrf_token() }}" },
            dataType: "json",
            success: function (data) {
                location.reload();
            },
            error: function (error) {
                console.error("Error:", error);
            },
        });
    }

    function incrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data("field");
        var parent = $(e.target).closest("div");
        var currentVal = parseInt(
            parent.find("input[name=" + fieldName + "]").val(),
            10
        );

        if (!isNaN(currentVal)) {
            parent.find("input[name=" + fieldName + "]").val(currentVal + 1);
        } else {
            parent.find("input[name=" + fieldName + "]").val(0);
        }
    }

    function decrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data("field");
        var parent = $(e.target).closest("div");
        var currentVal = parseInt(
            parent.find("input[name=" + fieldName + "]").val(),
            10
        );

        if (!isNaN(currentVal) && currentVal > 0) {
            parent.find("input[name=" + fieldName + "]").val(currentVal - 1);
        } else {
            parent.find("input[name=" + fieldName + "]").val(0);
        }
    }

    $(".input-group").on("click", ".button-plus", function (e) {
        incrementValue(e);
    });

    $(".input-group").on("click", ".button-minus", function (e) {
        decrementValue(e);
    });
});
