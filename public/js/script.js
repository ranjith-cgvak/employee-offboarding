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
        return [mnth, day, date.getFullYear()].join("/");
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
})