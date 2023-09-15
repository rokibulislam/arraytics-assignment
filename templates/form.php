<form id="arraytics-submission-form" action="" method="post">
    
    <div class="arraytics-form-group">
        <label for="amount"> Amount: </label>
        <input type="number" id="amount" name="amount" class="arraytics-form-control" />
        <p class="error-message"> </p>
    </div>

    <div class="arraytics-form-group">
        <label for="buyer"> Buyer: </label>
        <input type="text" id="buyer" name="buyer" maxlength="20" class="arraytics-form-control" />
        <p class="error-message"> </p>
    </div>

    <div class="arraytics-form-group">
        <label for="receipt_id"> Receipt ID: </label>
        <input type="text" id="receipt_id" name="receipt_id" maxlength="20" class="arraytics-form-control" />
        <p class="error-message"> </p>
    </div>

    <div class="arraytics-form-group items_container">
        <div class="item_fields">
            <div>
                <label for="items"> Items: </label>
                <input type="text" id="items" name="items[]" maxlength="255" class="arraytics-form-control" />
            </div>
            <button class="remove-field">Remove</button>
        </div>
        <p class="error-message"> </p>
    </div>

    <button id="addField">Add Field</button>

    <div class="arraytics-form-group">
        <label for="buyer_email">Buyer Email:</label>
        <input type="email" id="buyer_email" name="buyer_email" maxlength="50" class="arraytics-form-control" />
        <p class="error-message"> </p>
    </div>

    <div class="arraytics-form-group">
        <input type="hidden" name="buyer_ip" value="AUTO-FILL-IN-BACKEND">
        <input type="hidden" name="hash_key" value="AUTO-GENERATE-IN-BACKEND">
        <input type="hidden" name="entry_at" value="AUTO-GENERATE-IN-BACKEND">
        <input type="hidden" name="action" value="save_arraytics">
    </div>

    <div class="arraytics-form-group">
        <label for="note">Note:</label>
        <textarea id="note" name="note" rows="4" maxlength="30" class="arraytics-form-control"></textarea>
        <p class="error-message"> </p>
    </div>

    <div class="arraytics-form-group">
        <label for="city">City:</label>
        <input type="text" id="city" name="city" maxlength="20" class="arraytics-form-control" />
        <p class="error-message"> </p>
    </div>

    <div class="arraytics-form-group">
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" pattern="[0-9]{11}"  class="arraytics-form-control" />
        <p class="error-message"> </p>
    </div>

    <div class="arraytics-form-group">
        <label for="entry_by">Entry By:</label>
        <input type="number" id="entry_by" name="entry_by" class="arraytics-form-control" />
        <p class="error-message"> </p>
    </div>
    
    <div class="arraytics-form-group">
        <!-- <input type="submit" id="arraytics-submission-form" class="btn-arraytics-submit" value="Submit"> -->
        <button type="submit" class="btn-arraytics-submit"> Submit </button>
    </div>

</form>

<div id="form-message"></div>


