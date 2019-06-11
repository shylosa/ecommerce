$(function ($) {
  const url = $('#get_attribute_cases').data('url');

  if (!url) {
    return;
  }

  $('body').on('change', '.js-product-attribute', function () {
    let $attributeSelect = $(this);

    if (!$attributeSelect.val()) {
      return;
    }

    let casesUrl = url.replace('---id---', $attributeSelect.val());
    let $valueSelect = $attributeSelect.closest('tr').find('select.js-product-attribute-value');
    let currentValue = $valueSelect.val();

    $.get(casesUrl, function (cases) {
      let selected = !currentValue;

      $valueSelect.html('');

      for (let i = 0; i < cases.length; i++) {
        if (currentValue && cases[i].id == currentValue) {
          selected = true;
        }

        $valueSelect.append(new Option(cases[i].value, cases[i].id, selected, selected));
        selected = false;
      }

      $valueSelect.trigger('change');
    });
  });

  $('.js-product-attribute').trigger('change');
  $('body').on('sonata.add_element', '[id$=_attributeValues] .field-container', function(event) {
    $('.js-product-attribute').trigger('change');
  })
});