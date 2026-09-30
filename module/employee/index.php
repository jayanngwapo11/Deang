<?php
// Employee module
require_once("../../include/initialize.php");

$view = isset($_GET['view']) ? $_GET['view'] : '';

if ($view === 'view') {
  $title   = "Employee Profile";
  $content = 'view.php';
} else {
  $title   = "Employee";
  $content = 'list.php';
}

require_once("../../theme/template.php");
?>

<script type="text/javascript">
var employeeTable;
var currentStatusFilter = '';

$(document).ready(function() {

  employeeTable = $('#tblemployeelist').DataTable({
    "processing": true,
    "serverSide": true,
    "scrollX": true,
    "order": [],
    "ajax": {
      url: "<?php echo WEB_ROOT; ?>module/employee/ajax.php",
      type: "POST",
      data: function (d) { d.status_filter = currentStatusFilter; }
    },
      "columnDefs": [
      { "orderable": false, "targets": [11] }
    ]
  });

  $('#statusFilters button').on('click', function(){
    $('#statusFilters button').removeClass('active');
    $(this).addClass('active');
    currentStatusFilter = $(this).data('filter');
    employeeTable.ajax.reload();
  });

  /* Open the SOA-formatted employee report; carry the active status filter. */
  $('#printEmployees').on('click', function () {
    var url = "<?php echo WEB_ROOT; ?>module/employee/print.php";
    if (currentStatusFilter === '1' || currentStatusFilter === '0') {
      url += "?status=" + currentStatusFilter;
    }
    window.open(url, "_blank");
  });

  /* Add: reset the form to a blank Add state. */
  $('#btnAddEmployee').on('click', function(){
    $('#employeeModalTitle').text('Add Employee');
    $('#EMP_ID').val('0');
    $('#E_FNAME').val('');
    $('#E_MNAME').val('');
    $('#E_LNAME').val('');
    $('#E_SUFFIX').val('');
    $('#E_EMAIL').val('');
    $('#E_PHONE').val('');
    $('#E_DOB').val('');
    $('#E_HIRE').val('');
    $('#E_JOBTITLE').val('');
    $('#E_DEPARTMENT').val('');
    $('#E_SALARY').val('');
    $('#E_MANAGER').val('');
    $('#E_ISACTIVE').val('1');
    $('#employeeModal').modal('show');
  });

  /* Edit: load the row into the same modal. */
  $(document).on('click', '.editEmployee', function(){
    var id = $(this).attr('EID');
    $.ajax({
      url: "<?php echo WEB_ROOT; ?>module/employee/ajax.php",
      method: "POST",
      data: { act: 'row', EmployeeID: id },
      dataType: "json",
      success: function(d) {
        $('#employeeModalTitle').text('Edit Employee');
        $('#EMP_ID').val(d.EmployeeID || '0');
        $('#E_FNAME').val(d.FirstName || '');
        $('#E_MNAME').val(d.MiddleName || '');
        $('#E_LNAME').val(d.LastName || '');
        $('#E_SUFFIX').val(d.Suffix || '');
        $('#E_EMAIL').val(d.Email || '');
        $('#E_PHONE').val(d.Phone || '');
        $('#E_DOB').val(d.DateOfBirth || '');
        $('#E_HIRE').val(d.HireDate || '');
        $('#E_JOBTITLE').val(d.JobTitle || '');
        $('#E_DEPARTMENT').val(d.Department || '');
        $('#E_SALARY').val(d.Salary || '');
        /* An employee should not be offered as their own manager. */
        $('#E_MANAGER option').prop('disabled', false);
        $('#E_MANAGER option[value="' + d.EmployeeID + '"]').prop('disabled', true);
        $('#E_MANAGER').val(d.ManagerID || '');
        $('#E_ISACTIVE').val(String(d.IsActive));
        $('#employeeModal').modal('show');
      },
      error: function() { alert('Could not load that employee record.'); }
    });
  });

});
</script>