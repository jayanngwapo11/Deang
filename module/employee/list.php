<?php
/* Employee module - HR records. $mydb is ready (initialize.php via template). */
global $mydb;

/* Managers dropdown = every existing employee. */
$managers = array();
$mydb->setQuery("SELECT EmployeeID, FirstName, LastName FROM `tblemployee` ORDER BY LastName ASC, FirstName ASC");
foreach ($mydb->loadResultList() as $m) { $managers[] = $m; }
?>
<section class="content">
  <div class="container-fluid">
    <?php check_message(); ?>
    <div class="row">
      <div class="col-12">
        <div class="card card-outline card-primary">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-user-tie"></i>&nbsp; Employees</h3>
            <div class="card-tools">
              <div class="btn-group" id="statusFilters">
                <button type="button" class="btn btn-sm btn-outline-secondary active" data-filter="">All</button>
                <button type="button" class="btn btn-sm btn-outline-success" data-filter="1">Active</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-filter="0">Inactive</button>
              </div>
              <button type="button" class="btn btn-sm btn-primary ml-2" id="btnAddEmployee">
                <i class="fa fa-plus"></i> Add Employee
              </button>
              <button type="button" id="printEmployees" class="btn btn-sm btn-default ml-2">
                <i class="fa fa-print"></i> Print
              </button>
            </div>
          </div>
          <div class="card-body">
            <table id="tblemployeelist" class="table table-bordered table-striped" style="width:100%">
              <thead>
                                <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>Suffix</th>
                  <th>Email</th>
                  <th>Job Title</th>
                  <th>Department</th>
                  <th>Manager</th>
                  <th>Hire Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== ADD / EDIT EMPLOYEE ===================== -->
<div class="modal fade" id="employeeModal">
  <div class="modal-dialog modal-lg">
        <form action="controller.php?action=save" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="E_PHOTO_OLD" id="E_PHOTO_OLD" value="">
      <input type="hidden" name="EMP_ID" id="EMP_ID" value="0">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title"><i class="fa fa-user-tie"></i>&nbsp; <span id="employeeModalTitle">Add Employee</span></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="row">

            <div class="col-sm-12 text-center mb-3">
              <div class="form-group">
                <label class="col-form-label-sm d-block">Employee Photo</label>
                <img id="E_PHOTO_PREVIEW" src="data:image/svg+xml;utf8,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20viewBox%3D%270%200%20100%20100%27%3E%3Crect%20width%3D%27100%27%20height%3D%27100%27%20fill%3D%27%23ddd%27%2F%3E%3Ccircle%20cx%3D%2750%27%20cy%3D%2738%27%20r%3D%2718%27%20fill%3D%27%23aaa%27%2F%3E%3Cellipse%20cx%3D%2750%27%20cy%3D%2788%27%20rx%3D%2730%27%20ry%3D%2722%27%20fill%3D%27%23aaa%27%2F%3E%3C%2Fsvg%3E" style="width:90px;height:90px;object-fit:cover;border-radius:50%;border:2px solid #ddd;">
                <input type="file" class="form-control form-control-sm mt-2" name="E_PHOTO" id="E_PHOTO" accept="image/*" style="max-width:300px;margin:0 auto;">
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label class="col-form-label-sm">First Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" name="E_FNAME" id="E_FNAME" required>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="col-form-label-sm">Middle Name</label>
                <input type="text" class="form-control form-control-sm" name="E_MNAME" id="E_MNAME">
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="col-form-label-sm">Last Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" name="E_LNAME" id="E_LNAME" required>
              </div>
            </div>
                        <div class="col-sm-1">
              <div class="form-group">
                <label class="col-form-label-sm">Suffix</label>
                <select class="form-control form-control-sm" name="E_SUFFIX" id="E_SUFFIX">
                  <option value="">None</option>
                  <option value="Jr.">Jr.</option>
                  <option value="Sr.">Sr.</option>
                  <option value="II">II</option>
                  <option value="III">III</option>
                  <option value="IV">IV</option>
                  <option value="V">V</option>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="col-form-label-sm">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control form-control-sm" name="E_EMAIL" id="E_EMAIL" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="col-form-label-sm">Phone</label>
                <input type="text" class="form-control form-control-sm" name="E_PHONE" id="E_PHONE">
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label class="col-form-label-sm">Date of Birth</label>
                <input type="date" class="form-control form-control-sm" name="E_DOB" id="E_DOB">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="col-form-label-sm">Hire Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control form-control-sm" name="E_HIRE" id="E_HIRE" required>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label class="col-form-label-sm">Job Title</label>
                <input type="text" class="form-control form-control-sm" name="E_JOBTITLE" id="E_JOBTITLE">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="col-form-label-sm">Department</label>
                <input type="text" class="form-control form-control-sm" name="E_DEPARTMENT" id="E_DEPARTMENT">
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label class="col-form-label-sm">Salary</label>
                <input type="number" step="0.01" min="0" class="form-control form-control-sm" name="E_SALARY" id="E_SALARY">
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-group">
                <label class="col-form-label-sm">Manager</label>
                <select class="form-control form-control-sm" name="E_MANAGER" id="E_MANAGER">
                  <option value="">None</option>
                  <?php foreach ($managers as $m) { ?>
                  <option value="<?php echo $m->EmployeeID; ?>"><?php echo htmlspecialchars($m->LastName.', '.$m->FirstName); ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="col-form-label-sm">Status</label>
                <select class="form-control form-control-sm" name="E_ISACTIVE" id="E_ISACTIVE">
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Employee</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-----END of Employee Form---->