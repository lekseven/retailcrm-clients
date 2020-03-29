import $ from 'jquery';
import 'inputmask/dist/jquery.inputmask';

const $clientAddresses = $('#client_addresses');
const $addAddressButton = $('.js-add-address');
const ADDRESS_LIMIT = parseInt($addAddressButton.data('address-limit')) || 1;

$clientAddresses.data('index', $clientAddresses.find('fieldset').length);

$addAddressButton.on('click', function () {
    const formPrototype = $clientAddresses.data('prototype');
    let index = $clientAddresses.data('index');

    $clientAddresses.append(formPrototype.replace(/__name__/g, index));
    $clientAddresses.data('index', index + 1);

    const addressesCount = $clientAddresses.find('fieldset').length;
    if (addressesCount === ADDRESS_LIMIT) {
        $(this).hide();
    }
});

$('body').on('click', '.js-remove-address', function () {
    $(this).closest('fieldset').remove();

    const addressesCount = $clientAddresses.find('fieldset').length;
    if (addressesCount < ADDRESS_LIMIT) {
        $addAddressButton.show();
    }
});

$('#client_phone').inputmask({
    'mask': '+7 (999) 999-9999',
    'removeMaskOnSubmit': true,
    'clearMaskOnLostFocus': false,
});
