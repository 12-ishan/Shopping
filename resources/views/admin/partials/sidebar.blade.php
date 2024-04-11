<!-- sidebar menu area start -->
<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <!-- <a href="index.html"><img src="{{ asset('assets/admin/images/icon/logo.png') }}" alt="logo"></a> -->
            <p style="color:#fff; text-decoration: underline;">Application Dashboard</p>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li @if(isset($activeMenu)) @if($activeMenu=='dashboard' ) class="active" @endif @endif>
                        <a href="{{ url('/admin/dashboard') }}"><i class="ti-dashboard"></i><span>dashboard</span></a>
                        <!-- <ul class="collapse">
                                    <li><a href="index.html">SEO dashboard</a></li>
                                    <li class="active"><a href="index2.html">Ecommerce dashboard</a></li>
                                    <li><a href="index3.html">ICO dashboard</a></li>
                                </ul> -->
                    </li>

                    <?php /* ?>

                    <li @if(isset($activeMenu)) @if($activeMenu=='promoter' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Manage Promoters
                            </span></a>
                        <ul class="collapse">
                            <li><a href="{{ url('/admin/promoter/create') }}">Add</a></li>
                            <li><a href="{{ url('/admin/promoter/') }}">Manage</a></li>
                        </ul>
                    </li>

                    <li @if(isset($activeMenu)) @if($activeMenu=='contract' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-layout-sidebar-left"></i>
                            <span>Contract Management</span></a>
                        <ul class="collapse">

                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='agency' ) class="active" @endif @endif>
                                <a href="#" aria-expanded="true">Agency</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/agency/create') }}">Add</a></li>
                                    <li><a href="{{ url('/admin/agency/') }}">Manage</a></li>
                                </ul>
                            </li>

                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='agent' ) class="active" @endif @endif>
                                <a href="#" aria-expanded="true">Agent</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/agent/create') }}">Add</a></li>
                                    <li><a href="{{ url('/admin/agent/') }}">Manage</a></li>
                                </ul>
                            </li>

                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='artist' ) class="active" @endif @endif>
                                <a href="#" aria-expanded="true">Artist</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/artist/create') }}">Add</a></li>
                                    <li><a href="{{ url('/admin/artist/') }}">Manage</a></li>
                                </ul>
                            </li>

                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='contract' ) class="active" @endif
                                @endif>
                                <a href="#" aria-expanded="true">Contract</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/contract/create') }}">Add</a></li>
                                    <li><a href="{{ url('/admin/contract/') }}">Manage</a></li>
                                </ul>
                            </li>

                        </ul>
                    </li>

                    <li @if(isset($activeMenu)) @if($activeMenu=='general' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-align-left"></i> <span>General
                                Settings</span></a>
                        <ul class="collapse">

                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='country' ) class="active" @endif @endif>
                                <a href="#" aria-expanded="true">Country</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/country/create') }}">Add</a></li>
                                    <li><a href="{{ url('/admin/country/') }}">Manage</a></li>
                                </ul>
                            </li>

                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='applicationNumber' ) class="active"
                                @endif @endif>
                                <a href="#" aria-expanded="true">Application Number's</a>
                                <ul class="collapse">
                                    <!-- <li><a href="{{ url('/admin/application-number/create') }}">Add</a></li> -->
                                    <li><a href="{{ url('/admin/application-number/') }}">Manage</a></li>
                                </ul>
                            </li>

                        </ul>
                    </li>


                    <?php */ ?>

                    <?php /* ?>
                    <li @if(isset($activeMenu)) @if($activeMenu=='configurator' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Configuartor Pricing
                            </span></a>


                        <ul class="collapse">
                            <li><a href="{{ url('/admin/product-dimension/1') }}">By Dimension</a></li>
                            <li><a href="{{ url('/admin/shutter-type/1') }}">Shutter Type</a></li>
                            <li><a href="{{ url('/admin/shutter-style/1') }}">Shutter Style</a></li>
                            <li><a href="{{ url('/admin/color/1') }}">Color</a></li>
                            <li><a href="{{ url('/admin/frame/1') }}">Frame Option</a></li>
                            <li><a href="{{ url('/admin/recess/1') }}">Inside/Outside Recess</a></li>
                            <li><a href="{{ url('/admin/pannel/1') }}">Panel Configuration</a></li>
                            <li><a href="{{ url('/admin/louvre/1') }}">Louvre Configuration</a></li>
                            <li><a href="{{ url('/admin/tiltrod/1') }}">Titrod Type</a></li>
                            <li><a href="{{ url('/admin/hinge/1') }}">Hinge</a></li>

                            <!-- <li><a href="#" aria-expanded="true">Item level (1)</a>
                                        <ul class="collapse">
                                            <li><a href="#">Item level (2)</a></li>
                                            <li><a href="#">Item level (2)</a></li>
                                            <li><a href="#">Item level (2)</a></li>
                                        </ul>
                                    </li> -->

                        </ul>
                    </li>

                    <li @if(isset($activeMenu)) @if($activeMenu=='order' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Orders
                            </span></a>


                        <ul class="collapse">
                            <li><a href="{{ url('/admin/order') }}">Manage Orders</a></li>


                            <!-- <li><a href="#" aria-expanded="true">Item level (1)</a>
                                        <ul class="collapse">
                                            <li><a href="#">Item level (2)</a></li>
                                            <li><a href="#">Item level (2)</a></li>
                                            <li><a href="#">Item level (2)</a></li>
                                        </ul>
                                    </li> -->

                        </ul>
                    </li>
                    <li @if(isset($activeMenu)) @if($activeMenu=='customer' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Customers
                            </span></a>


                        <ul class="collapse">
                            <li><a href="{{ url('/admin/customer') }}">Manage Customers</a></li>
                            <li><a href="{{ url('/admin/customer/create') }}">Add Customer</a></li>


                            <!-- <li><a href="#" aria-expanded="true">Item level (1)</a>
                                        <ul class="collapse">
                                            <li><a href="#">Item level (2)</a></li>
                                            <li><a href="#">Item level (2)</a></li>
                                            <li><a href="#">Item level (2)</a></li>
                                        </ul>
                                    </li> -->

                        </ul>
                    </li>
                    <?php */ ?>

                    @if(isset(Auth::user()->roleId))
                    @if(Auth::user()->roleId == 1)


                    <li @if(isset($activeMenu)) @if($activeMenu=='master' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Master MGMT
                            </span></a>

                            <ul class="collapse">
                                <li @if(isset($activeSubMenu)) @if($activeSubMenu=='bloodGroup' ) class="active" @endif @endif>
                                    <a href="#" aria-expanded="true">Blood Group</a>
                                    <ul class="collapse">
                                        <li><a href="{{ url('/admin/bloodGroup') }}">Manage Blood Group</a></li>
                                        <li><a href="{{ url('/admin/bloodGroup/create') }}">Add Blood Group</a></li>
                                    </ul>
                                </li>
                            </ul>

                            <ul class="collapse">
                                <li @if(isset($activeSubMenu)) @if($activeSubMenu=='board' ) class="active" @endif @endif>
                                    <a href="#" aria-expanded="true">Board</a>
                                    <ul class="collapse">
                                        <li><a href="{{ url('/admin/board') }}">Manage Board</a></li>
                                        <li><a href="{{ url('/admin/board/create') }}">Add Board</a></li>
                                    </ul>
                                </li>
                            </ul>

                            <ul class="collapse">
                                <li @if(isset($activeSubMenu)) @if($activeSubMenu=='city' ) class="active" @endif @endif>
                                    <a href="#" aria-expanded="true">City</a>
                                    <ul class="collapse">
                                        <li><a href="{{ url('/admin/city') }}">Manage City</a></li>
                                        <li><a href="{{ url('/admin/city/create') }}">Add City</a></li>
                                    </ul>
                                </li>
                            </ul>    
                            <ul class="collapse">
                                <li @if(isset($activeSubMenu)) @if($activeSubMenu=='coupon' ) class="active" @endif @endif>
                                    <a href="#" aria-expanded="true">Coupons</a>
                                    <ul class="collapse">
                                        <li><a href="{{ url('/admin/coupon') }}">Manage Coupons</a></li>
                                        <li><a href="{{ url('/admin/coupon/create') }}">Add Coupons</a></li>
                                    </ul>
                                </li>
                            </ul>    

                            <ul class="collapse">
                                <li @if(isset($activeSubMenu)) @if($activeSubMenu=='degree' ) class="active" @endif @endif>
                                    <a href="#" aria-expanded="true">Degree</a>
                                    <ul class="collapse">
                                        <li><a href="{{ url('/admin/degree') }}">Manage Degree</a></li>
                                        <li><a href="{{ url('/admin/degree/create') }}">Add Degree</a></li>
                                    </ul>
                                </li>
                            </ul>

                            <ul class="collapse">
                                <li @if(isset($activeSubMenu)) @if($activeSubMenu=='gender' ) class="active" @endif @endif>
                                    <a href="#" aria-expanded="true">Gender</a>
                                    <ul class="collapse">
                                        <li><a href="{{ url('/admin/gender') }}">Manage Gender</a></li>
                                        <li><a href="{{ url('/admin/gender/create') }}">Add Gender</a></li>
                                    </ul>
                                </li>
                            </ul>

                            <ul class="collapse">
                                <li @if(isset($activeSubMenu)) @if($activeSubMenu=='awardsLevel' ) class="active" @endif @endif>
                                    <a href="#" aria-expanded="true">Level of Awards/Recognition</a>
                                    <ul class="collapse">
                                        <li><a href="{{ url('/admin/awardsLevel') }}">Manage Level of Awards/Recognition</a></li>
                                        <li><a href="{{ url('/admin/awardsLevel/create') }}">Add Level of Awards/Recognition</a></li>
                                    </ul>
                                </li>
                            </ul>

                            <ul class="collapse">
                                <li @if(isset($activeSubMenu)) @if($activeSubMenu=='mode' ) class="active" @endif @endif>
                                    <a href="#" aria-expanded="true">Mode</a>
                                    <ul class="collapse">
                                        <li><a href="{{ url('/admin/mode') }}">Manage Mode</a></li>
                                        <li><a href="{{ url('/admin/mode/create') }}">Add Mode</a></li>
                                    </ul>
                                </li>
                            </ul>

                            <ul class="collapse">
                                <li @if(isset($activeSubMenu)) @if($activeSubMenu=='paymentHistory' ) class="active" @endif @endif>
                                    <a href="#" aria-expanded="true">Payment History</a>
                                    <ul class="collapse">
                                        <li><a href="{{ url('/admin/paymentHistory') }}">Manage Payment History</a></li>
                                       
                                    </ul>
                                </li>
                            </ul>    

                        <ul class="collapse">
                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='program' ) class="active" @endif @endif>
                                <a href="#" aria-expanded="true">Program</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/program') }}">Manage Program</a></li>
                                    <li><a href="{{ url('/admin/program/create') }}">Add Program</a></li>
                                </ul>
                            </li>
                        </ul>

                        <ul class="collapse">
                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='proficiencyLevel' ) class="active" @endif @endif>
                                <a href="#" aria-expanded="true">Proficiency Level</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/proficiencyLevel') }}">Manage Proficiency Level</a></li>
                                    <li><a href="{{ url('/admin/proficiencyLevel/create') }}">Add Proficiency Level</a></li>
                                </ul>
                            </li>
                        </ul>

                        <ul class="collapse">
                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='subject' ) class="active" @endif @endif>
                                <a href="#" aria-expanded="true">Subject</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/subject') }}">Manage Subject</a></li>
                                    <li><a href="{{ url('/admin/subject/create') }}">Add Subject</a></li>
                                </ul>
                            </li>
                        </ul>

                        <ul class="collapse">
                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='state' ) class="active" @endif @endif>
                                <a href="#" aria-expanded="true">State</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/state') }}">Manage State</a></li>
                                    <li><a href="{{ url('/admin/state/create') }}">Add State</a></li>
                                </ul>
                            </li>
                        </ul>

                        <ul class="collapse">
                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='salutation' ) class="active" @endif @endif>
                                <a href="#" aria-expanded="true">Salutation</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/salutation') }}">Manage Salutation</a></li>
                                    <li><a href="{{ url('/admin/salutation/create') }}">Add Salutation</a></li>
                                </ul>
                            </li>
                        </ul>

                        <ul class="collapse">
                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='stream' ) class="active" @endif @endif>
                                <a href="#" aria-expanded="true">Stream</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/stream') }}">Manage Stream</a></li>
                                    <li><a href="{{ url('/admin/stream/create') }}">Add Stream</a></li>
                                </ul>
                                
                            </li>
                        </ul>
                        <ul class="collapse">
                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='profile' ) class="active" @endif @endif>
                                <a href="#" aria-expanded="true">Profile</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/profile') }}">Manage Profile</a></li>
                                    <li><a href="{{ url('/admin/profile/create') }}">Add Profile</a></li>
                                </ul>
                                
                            </li>
                        </ul>
                       
                       

                        <ul class="collapse">
                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='topic' ) class="active" @endif @endif><a
                                    href="#" aria-expanded="true">Topic</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/topic') }}">Manage Topic</a></li>
                                    <li><a href="{{ url('/admin/topic/create') }}">Add Topic</a></li>

                                </ul>
                            </li>

                        </ul>
                        <!-- <ul class="collapse">
                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='state' ) class="active" @endif @endif><a
                                    href="#" aria-expanded="true">State</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/state') }}">Manage State</a></li>
                                    <li><a href="{{ url('/admin/state/create') }}">Add State</a></li>
                                </ul>
                            </li>
                        </ul> -->
                        <ul class="collapse">
                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='timeSlot' ) class="active" @endif
                                @endif><a href="#" aria-expanded="true">Time Slot</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/time-slot') }}">Manage Time Slot</a></li>
                                    <li><a href="{{ url('/admin/time-slot/create') }}">Add Time Slot</a></li>
                                </ul>
                            </li>
                        </ul>

                        <ul class="collapse">
                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='university' ) class="active" @endif @endif>
                                <a href="#" aria-expanded="true">University</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/university') }}">Manage University</a></li>
                                    <li><a href="{{ url('/admin/university/create') }}">Add University</a></li>
                                </ul>
                            </li>
                        </ul>

                    </li>

                    <li @if(isset($activeMenu)) @if($activeMenu=='teacher-class' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Class Teacher MGMT
                            </span></a>
                        <ul class="collapse">
                            <li><a href="{{ url('/admin/teacher-class') }}">Manage Class Teacher</a></li>
                            <li><a href="{{ url('/admin/teacher-class/create') }}">Assign Class Teacher</a></li>
                        </ul>
                    </li>


                    <li @if(isset($activeMenu)) @if($activeMenu=='question' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Question Bank MGMT
                            </span></a>

                        <ul class="collapse">

                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='questionCategory' ) class="active"
                                @endif @endif><a href="#" aria-expanded="true">Category</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/question-category') }}">Manage Category</a></li>
                                    <li><a href="{{ url('/admin/question-category/create') }}">Add Category</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ url('/admin/question') }}">Manage Question</a></li>
                            <li><a href="{{ url('/admin/question/create') }}">Add Question</a></li>

                        </ul>
                    </li>
                    @endif
                    @endif
 
                    @if(isset(Auth::user()->roleId))
                    @if(Auth::user()->roleId == 2)
                    <li @if(isset($activeMenu)) @if($activeMenu=='meeting' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Session
                            </span></a>
                        <ul class="collapse">
                            <li><a href="{{ url('/admin/teacher-meeting') }}">Manage Session</a></li>
                            <!-- <li><a href="{{ url('/admin/meeting/create') }}">Add Session</a></li> -->
                        </ul>
                    </li>
                    @endif
                    @endif

                    @if(isset(Auth::user()->roleId))
                    @if(Auth::user()->roleId == 1)
                    <li @if(isset($activeMenu)) @if($activeMenu=='meeting' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Session
                            </span></a>
                        <ul class="collapse">
                            <li><a href="{{ url('/admin/meeting') }}">Manage Session</a></li>
                            <!-- <li><a href="{{ url('/admin/meeting/create') }}">Add Session</a></li> -->
                        </ul>
                    </li>
                    @endif
                    @endif

                    @if(isset(Auth::user()->roleId))
                    @if(Auth::user()->roleId == 1)

                    <li @if(isset($activeMenu)) @if($activeMenu=='plan' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Plan MGMT
                            </span></a>
                        <ul class="collapse">
                            <li><a href="{{ url('/admin/plan') }}">Manage Plans</a></li>
                            <!-- <li><a href="{{ url('/admin/plan/create') }}">Assign Class Teacher</a></li> -->
                        </ul>
                    </li>


                   


                    <li @if(isset($activeMenu)) @if($activeMenu=='order' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Order MGMT
                            </span></a>


                        <ul class="collapse">
                            <li><a href="{{ url('/admin/order') }}">Order History</a></li>


                        </ul>
                    </li>

                    <li @if(isset($activeMenu)) @if($activeMenu=='application' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Application Manager
                            </span></a>
                        <ul class="collapse">
                            <li><a href="{{ url('/admin/application') }}">Manage Application</a></li>
                            <li><a href="{{ url('/admin/application/create') }}">Add Application</a></li>


                        </ul>
                    </li>

                    <li @if(isset($activeMenu)) @if($activeMenu=='contact' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Contact
                            </span></a>


                        <ul class="collapse">
                            <li><a href="{{ url('/admin/contact') }}">Manage Contact</a></li>
                            <li><a href="{{ url('/admin/contact/create') }}">Add Contact</a></li>


                        </ul>
                    </li>

                    <li @if(isset($activeMenu)) @if($activeMenu=='studentManager' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Student Manager
                            </span></a>
                        <ul class="collapse">
                            <li><a href="{{ url('/admin/studentManager') }}">Manage Student</a></li>
                            <li><a href="{{ url('/admin/studentManager/create') }}">Add Student</a></li>


                        </ul>
                    </li>


                    <li @if(isset($activeMenu)) @if($activeMenu=='user' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>User
                            </span></a>
                        <ul class="collapse">
                            <li><a href="{{ url('/admin/user') }}">Manage Users</a></li>
                            <li><a href="{{ url('/admin/user/create') }}">Add User</a></li>


                        </ul>
                    </li>

                    <li @if(isset($activeMenu)) @if($activeMenu=='role' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Role
                            </span></a>

                        <ul class="collapse">
                            <li><a href="{{ url('/admin/role') }}">Manage Role</a></li>
                            <li><a href="{{ url('/admin/role/create') }}">Add Role</a></li>
                        </ul>
                    </li>

                    <li @if(isset($activeMenu)) @if($activeMenu=='permissionHead' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Permission Head
                            </span></a>

                        <ul class="collapse">
                            <li><a href="{{ url('/admin/permissionHead') }}">Manage</a></li>
                            <li><a href="{{ url('/admin/permissionHead/create') }}">Add</a></li>
                        </ul>
                    </li>



                    <li @if(isset($activeMenu)) @if($activeMenu=='website-management' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Website management
                            </span></a>
                        <ul class="collapse">
                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='testimonial' ) class="active" @endif
                                @endif>
                                <a href="#" aria-expanded="true">Testimonial</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/testimonial') }}">Manage Testimonial</a></li>
                                    <li><a href="{{ url('/admin/testimonial/create') }}">Add Testimonial</a></li>
                                </ul>
                            </li>
                        </ul>


                        <ul class="collapse">
                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='banner' ) class="active" @endif @endif>
                                <a href="#" aria-expanded="true">Banner</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/banner') }}">Manage Banner</a></li>
                                    <li><a href="{{ url('/admin/banner/create') }}">Add Banner</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="collapse">
                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='blog' ) class="active" @endif @endif>
                                <a href="#" aria-expanded="true">Blog</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/blog') }}">Manage Blog</a></li>
                                    <li><a href="{{ url('/admin/blog/create') }}">Add Blog</a></li>
                                </ul>
                            </li>

                        </ul>

                        <ul class="collapse">
                            <li @if(isset($activeSubMenu)) @if($activeSubMenu=='page' ) class="active" @endif @endif>
                                <a href="#" aria-expanded="true">Page</a>
                                <ul class="collapse">
                                    <li><a href="{{ url('/admin/page') }}">Manage Page</a></li>
                                    <li><a href="{{ url('/admin/page/create') }}">Add Page</a></li>
                                </ul>
                            </li>

                        </ul>

                    </li>
                   
                    @endif
                    @endif

                    <?php /* ?>

                    <li @if(isset($activeMenu)) @if($activeMenu=='meeting-teacher-scheduling' ) class="active" @endif
                        @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Meeting Teacher Scheduling
                            </span></a>


                        <ul class="collapse">
                            <li><a href="{{ url('/admin/meeting-teacher-scheduling') }}">Manage Meeting Teacher
                                    Scheduling</a></li>
                            <li><a href="{{ url('/admin/meeting-teacher-scheduling/create') }}">Add Meeting Teacher
                                    Scheduling</a></li>


                        </ul>
                    </li>


                    <li @if(isset($activeMenu)) @if($activeMenu=='subscription' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Subscription
                            </span></a>


                        <ul class="collapse">
                            <li><a href="{{ url('/admin/subscription') }}">Manage Subscription</a></li>
                            <li><a href="{{ url('/admin/subscription/create') }}">Add Subscription</a></li>


                        </ul>
                    </li>

                    <li @if(isset($activeMenu)) @if($activeMenu=='subscription-member' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Subscription Member
                            </span></a>


                        <ul class="collapse">
                            <li><a href="{{ url('/admin/subscription-member') }}">Manage Subscription Member</a></li>
                            <li><a href="{{ url('/admin/subscription-member/create') }}">Add Subscription Member</a>
                            </li>


                        </ul>
                    </li>




                    <li @if(isset($activeMenu)) @if($activeMenu=='general' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>General Settings
                            </span></a>


                        <ul class="collapse">

                            <!-- <li><a href="{{ url('/admin/order') }}">Website</a></li> -->


                            <li><a href="#" aria-expanded="true">website</a>
                                <ul class="collapse">
                                    <li><a href="#">HomePage</a></li>
                                    <!-- <li><a href="#">Item level (2)</a></li>
                                            <li><a href="#">Item level (2)</a></li> -->
                                </ul>
                            </li>

                        </ul>
                    </li>
                    <?php */ ?>




                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- sidebar menu area end -->