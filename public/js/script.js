$(document).ready(function(){
  // add months to a date function
    function addMonths(date, months) {
        var d = date.getDate();
        date.setMonth(date.getMonth() + +months);
        if (date.getDate() != d) {
          date.setDate(0);
        }
        return date;
    }
    //converting a date function
    function convert(str) {
        var date = new Date(str),
          mnth = ("0" + (date.getMonth() + 1)).slice(-2),
          day = ("0" + date.getDate()).slice(-2);
        return [ day,mnth, date.getFullYear()].join("-");
      }

    //Hooking the input value to the date converted
    $('#dateOfResignation').change(function(){
        var date = new Date($('#dateOfResignation').val());
        var currentDay = date.getDay();
        var saturday = currentDay === 6 ;
        var sunday = currentDay === 0 ;
        if(saturday){
          date.setDate(date.getDate() + 2);
        } else if(sunday) {
          date.setDate(date.getDate() + 1);
        }
        var leavingdate = addMonths(date,3);
        var convertedDate = convert(leavingdate);
        $('#dateOfLeaving').val(convertedDate);
    })

    //Adding tooltip
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })

    //Disable the past dates in the date picker
    var today = new Date().toISOString().split('T')[0];
    document.getElementsByClassName("disablePast")[0].setAttribute('min', today);


    //HR EXIT INTERVIEW
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    var tableBody = $(".table_body_wrap");
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
      e.preventDefault();
      if(x < max_fields){ //max input box allowed
        x++; //text box increment
        // $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
        $(tableBody).append(`
        <tr>
        <td>
            <input type="text" name='hr_exitinterview_comment[]' class="form-control" required>
        </td>
        <td>
            <select name="hr_exitinterview_actionarea[]" class="form-control" required>
                <option value="">Select</option>
                <option value="Salary">Salary</option>
                <option value="Leave and Holiday">Leave and Holiday</option>
                <option value="Benifits">Benifits</option>
            </select>
        </td>
        <td>
        <button type="button" class="remove_field btn btn-danger">Remove</button>
        <td>
        </tr>
        `);
      }
    });

    $(tableBody).on("click",".remove_field", function(e){ //user click on remove text
      e.preventDefault(); $(this).parent('td').parent('tr').remove(); x--;
    })

})
