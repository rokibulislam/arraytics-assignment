jQuery(document).ready(function($) {
    $(document).on( 'click', ".remove-field", function(e) {
        e.preventDefault();
        console.log("remove");
        $(this).parent().parent(".item_fields").remove();
    });

    // Function to clone the first field group
    function cloneFieldGroup() {
        const firstFieldGroup = $(".items_container .item_fields:first").clone();
        firstFieldGroup.find("input").val(""); // Clear the input value
        $(".items_container").append(firstFieldGroup);
    }

    $(document).on( 'click', "#addField", function(e) {
        e.preventDefault();
        cloneFieldGroup();
    });
    
});