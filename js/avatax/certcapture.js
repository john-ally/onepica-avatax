var AvaTaxCert = Class.create();

AvaTaxCert.initApi = function (tokenUrl) {
    if (GenCert.getStatus() != 0) {
        GenCert.hide();
    }
    var ship_zone = $("ship_zone").value,
        customer_number = $("customer_number").value,
        form_element = $("avatax_certcapture_form_parent");

    form_element.className = "";

    new Ajax.Request(tokenUrl, {
        method: "POST",
        parameters: {
            url: tokenUrl,
            customerNumber: customer_number
        },
        requestHeaders: {Accept: "application/json"},
        onSuccess: function (transport) {
            try {
                if (transport.responseText) {
                    var response = transport.responseText.evalJSON(true);
                    if (response.success) {
                        GenCert.init(form_element, {
                            token: response.token,
                            ship_zone: ship_zone,
                            onCertSuccess: function () {
                                var message = "Certificate id created successfully: " + GenCert.certificateIds;
                                alert(message);
                                console.log(message);
                            },
                        });

                        GenCert.show();
                        $("avatax_certcapture_form_submit").hide();
                    } else {
                        console.log(response.message);
                    }
                }
            } catch (e) {
                console.log(e);
            }
        }.bind(this)
    });
};

AvaTaxCert.showPopup = function (url, title) {
    win = new Window({
        title: title,
        url: url,
        id: "avatax_certcapture",
        zIndex: 3000,
        destroyOnClose: true,
        recenterAuto: false,
        resizable: false,
        width: 780,
        height: 540,
        minimizable: false,
        maximizable: false,
        draggable: false
    });
    win.showCenter(true);
};
