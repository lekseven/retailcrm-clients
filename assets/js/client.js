import $ from 'jquery';

const $addAddressButton = $('.js-add-address');
const $clientAddresses = $('#client_addresses');

$clientAddresses.data('index', $clientAddresses.find('fieldset').length);

$addAddressButton.on('click', () => {
    const prototype = $clientAddresses.data('prototype');
    const index = $clientAddresses.data('index');

    let newForm = prototype.replace(/__name__/g, index);

    $clientAddresses.data('index', index + 1);

    $clientAddresses.append(newForm);
});
