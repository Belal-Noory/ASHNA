<?php 
    include("../init.php");

    $menu = array(
        array("name"=>"Dashboard", "url"=>"index.php", "icon"=>"la-chart-area", "status"=>""),
        array("name"=>"Business", "url"=>"business.php", "icon"=>"la-business-time", "status"=>"active")  
        );
    
    include("./master/header.php");
?>

    <!-- END: Main Menu-->
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-body">
                <!-- Form wzard with step validation section start -->
                <section id="validation">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Validation Example</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form action="#" class="steps-validation wizard-notification">
                                            <!-- Step 1 -->
                                            <h6>Step 1</h6>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="firstName3">
                                                                First Name :
                                                                <span class="danger">*</span>
                                                            </label>
                                                            <input type="text" class="form-control required" id="firstName3" name="firstName">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lastName3">
                                                                Last Name :
                                                                <span class="danger">*</span>
                                                            </label>
                                                            <input type="text" class="form-control required" id="lastName3" name="lastName">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="emailAddress5">
                                                                Email Address :
                                                                <span class="danger">*</span>
                                                            </label>
                                                            <input type="email" class="form-control required" id="emailAddress5" name="emailAddress">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="location">
                                                                Select City :
                                                                <span class="danger">*</span>
                                                            </label>
                                                            <select class="c-select form-control required" id="location" name="location">
                                                                <option value="">Select City</option>
                                                                <option value="Amsterdam">Amsterdam</option>
                                                                <option value="Berlin">Berlin</option>
                                                                <option value="Frankfurt">Frankfurt</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="phoneNumber3">Phone Number :</label>
                                                            <input type="tel" class="form-control" id="phoneNumber3">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="date3">Date of Birth :</label>
                                                            <input type="date" class="form-control" id="date3">
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <!-- Step 2 -->
                                            <h6>Step 2</h6>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="proposalTitle3">
                                                                Proposal Title :
                                                                <span class="danger">*</span>
                                                            </label>
                                                            <input type="text" class="form-control required" id="proposalTitle3" name="proposalTitle">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="emailAddress6">
                                                                Email Address :
                                                                <span class="danger">*</span>
                                                            </label>
                                                            <input type="email" class="form-control required" id="emailAddress6" name="emailAddress">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="videoUrl3">Video URL :</label>
                                                            <input type="url" class="form-control" id="videoUrl3" name="videoUrl">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="jobTitle3">
                                                                Job Title :
                                                                <span class="danger">*</span>
                                                            </label>
                                                            <input type="text" class="form-control required" id="jobTitle3" name="jobTitle">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="shortDescription3">Short Description :</label>
                                                            <textarea name="shortDescription" id="shortDescription3" rows="4" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Form wzard with step validation section end -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <?php include("./master/footer.php"); ?>

    <script>
        $(document).ready(()=>{
            // Show form
            var form = $(".steps-validation").show();
            $(".steps-validation").steps({
                headerTag: "h6",
                bodyTag: "fieldset",
                transitionEffect: "fade",
                titleTemplate: '<span class="step">#index#</span> #title#',
                labels: {
                    finish: 'Submit'
                },
                onStepChanging: function (event, currentIndex, newIndex) {
                    // Allways allow previous action even if the current form is not valid!
                    if (currentIndex > newIndex) {
                        return true;
                    }
                    // Forbid next action on "Warning" step if the user is too young
                    if (newIndex === 3 && Number($("#age-2").val()) < 18) {
                        return false;
                    }
                    // Needed in some cases if the user went back (clean up)
                    if (currentIndex < newIndex) {
                        // To remove error styles
                        form.find(".body:eq(" + newIndex + ") label.error").remove();
                        form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                    }
                    form.validate().settings.ignore = ":disabled,:hidden";
                    return form.valid();
                },
                onFinishing: function (event, currentIndex) {
                    form.validate().settings.ignore = ":disabled";
                    return form.valid();
                },
                onFinished: function (event, currentIndex) {
                    alert("Submitted!");
                }
            });
        })

        // Initialize validation
        $(".steps-validation").validate({
            ignore: 'input[type=hidden]', // ignore hidden fields
            errorClass: 'danger',
            successClass: 'success',
            highlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            rules: {
                email: {
                    email: true
                }
            }
        });
       
    </script>