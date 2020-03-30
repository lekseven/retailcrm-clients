import $ from 'jquery';
import 'inputmask/dist/jquery.inputmask';

const $clientAddresses = $('#client_addresses');
const $addAddressButton = $('.js-add-address');
const ADDRESS_LIMIT = parseInt($addAddressButton.data('address-limit')) || 1;

$clientAddresses.data('index', $clientAddresses.find('fieldset').length);

const updateAddAddressButtonVisibility = () => {
    const addressesCount = $clientAddresses.find('fieldset').length;
    if (addressesCount >= ADDRESS_LIMIT) {
        $addAddressButton.hide();
    } else {
        $addAddressButton.show();
    }
};
updateAddAddressButtonVisibility();

$addAddressButton.on('click', function () {
    const formPrototype = $clientAddresses.data('prototype');
    let index = $clientAddresses.data('index');

    let newForm = formPrototype.replace(/__name__/g, index);
    $clientAddresses.append(newForm);

    $clientAddresses.data('index', index + 1);

    updateAddAddressButtonVisibility();
});

$('body').on('click', '.js-remove-address', function () {
    $(this).closest('fieldset').remove();

    updateAddAddressButtonVisibility();
});

$('#client_phone').inputmask({
    'mask': '+9 (999) 999-9999',
    'removeMaskOnSubmit': true,
    'clearMaskOnLostFocus': false,
    onUnMask: function(maskedValue, unmaskedValue) {
        return unmaskedValue.replace(/[+()\s-]/g, '');
    }
});
