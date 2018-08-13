/*
* add selected category terms to primary term select menu so a primary term can be selected.
* */
jQuery(document).ready(function ($) {

    let checkListContainerSelector = "#categorychecklist";
    $(checkListContainerSelector).change(function () {

        var currentlySelectedOption = $('#primary_term  option:selected').val();
        var checklistContainer = $(this).closest(checkListContainerSelector);
        var categoryChecklistListItems = $(checklistContainer).find('li');
        var selectOptions = "<option value=\"\">– Select  –</option>";
        var selectValue;

        categoryChecklistListItems.each(function () {

            let checkbox = $(this).find('input[type=checkbox]');
            let input = $(this).find('input');
            let label = $(this).find('label');

            // add to select menu if the category is selected and not 'Uncategorized'
            if ((checkbox.is(':checked')) && (label.text().trim() !== 'Uncategorized')) {
                // build options based on currently selected categories
                selectOptions += '<option value="' + input.attr('value') + '">' + label.text() + '</option>';
                // persist currently selected primary term
                if (input.attr('value') === currentlySelectedOption) {
                    selectValue = currentlySelectedOption;
                }
            }
        });

        let $primaryTerm = $("#primary_term");
        //populate select
        $primaryTerm.html(selectOptions);
        // set previously selected value
        $primaryTerm.val(selectValue)

    });

});
