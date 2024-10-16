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

                   

                       <li @if(isset($activeMenu)) @if($activeMenu=='Product' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Product Manager
                            </span></a>

                        <ul class="collapse">
                            <li><a href="{{ url('/admin/product') }}">Manage Product</a></li>
                            <li><a href="{{ url('/admin/product/create') }}">Add Product</a></li>


                        </ul>
                    </li>


                    <li @if(isset($activeMenu)) @if($activeMenu=='Landing Page' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Landing Page Manager
                            </span></a>

                        <ul class="collapse">
                            <li><a href="{{ url('/admin/landing-page') }}">Manage Landing Pages</a></li>
                            <li><a href="{{ url('/admin/landing-page/create') }}">Add Landing page</a></li>


                        </ul>
                    </li>



                    <li @if(isset($activeMenu)) @if($activeMenu=='Order' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Order Manager
                            </span></a>

                        <ul class="collapse">
                            <li><a href="{{ url('/admin/order') }}">Show Order</a></li>
                            {{-- <li><a href="{{ url('/admin/product/create') }}">Add Product</a></li> --}}


                        </ul>
                    </li>



                    <li @if(isset($activeMenu)) @if($activeMenu=='Product Category' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Product Category
                            </span></a>


                        <ul class="collapse">
                            <li><a href="{{ url('/admin/product-category') }}">Manage Category</a></li>
                            <li><a href="{{ url('/admin/product-category/create') }}">Add Category</a></li>


                        </ul>
                    </li>


                    <li @if(isset($activeMenu)) @if($activeMenu=='coupon' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Coupon Manager
                            </span></a>


                        <ul class="collapse">
                            <li><a href="{{ url('/admin/coupon') }}">Manage Coupon</a></li>
                            <li><a href="{{ url('/admin/coupon/create') }}">Add Coupon</a></li>


                        </ul>
                    </li>
                  
                   

                    @if(isset(Auth::user()->roleId))
                    @if(Auth::user()->roleId == 1)


                    <li @if(isset($activeMenu)) @if($activeMenu=='master' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Master MGMT
                            </span></a>


                            <ul class="collapse">
                                <li @if(isset($activeSubMenu)) @if($activeSubMenu=='attributes' ) class="active" @endif @endif>
                                    <a href="#" aria-expanded="true">Attributes</a>
                                    <ul class="collapse">
                                        <li><a href="{{ url('/admin/product-attributes') }}">Manage Attributes</a></li>
                                        <li><a href="{{ url('/admin/product-attributes/create') }}">Add Attributes</a></li>
                                    </ul>
                                </li>
                            </ul>


                            <ul class="collapse">
                                <li @if(isset($activeSubMenu)) @if($activeSubMenu=='options' ) class="active" @endif @endif>
                                    <a href="#" aria-expanded="true">Attributes Options</a>
                                    <ul class="collapse">
                                        <li><a href="{{ url('/admin/attribute-options') }}">Manage Options</a></li>
                                        <li><a href="{{ url('/admin/attribute-options/create') }}">Add Options</a></li>
                                    </ul>
                                </li>
                            </ul>

                    </li>

                    @endif
                    @endif
 
                    @if(isset(Auth::user()->roleId))
                    @if(Auth::user()->roleId == 1)
    
                    <li @if(isset($activeMenu)) @if($activeMenu=='generalSettings' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>General Settings
                            </span></a>
    
    
                        <ul class="collapse">
                           
                            <li><a href="{{ url('/admin/general-settings/home-page-setting') }}">Home Page Setting</a></li>
                            <li><a href="{{ url('/admin/general-settings/website-logo-setting') }}">Website logo Setting</a></li>
    
    
                        </ul>
                    </li>
                    @endif
                    @endif


                    @if(isset(Auth::user()->roleId))
                    @if(Auth::user()->roleId == 1)
    
                    <li @if(isset($activeMenu)) @if($activeMenu=='contact leads' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Contact Leads
                            </span></a>
    
    
                        <ul class="collapse">
                           
                            <li><a href="{{ url('/admin/contact/leads') }}">Manage</a></li>
    
                        </ul>
                    </li>
                    @endif
                    @endif
                  

                  

                    @if(isset(Auth::user()->roleId))
                    @if(Auth::user()->roleId == 1)

                   

                    <li @if(isset($activeMenu)) @if($activeMenu=='contact' ) class="active" @endif @endif>
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-layout-sidebar-left"></i><span>Contact
                            </span></a>


                        <ul class="collapse">
                            <li><a href="{{ url('/admin/contact') }}">Manage Contact</a></li>
                            <li><a href="{{ url('/admin/contact/create') }}">Add Contact</a></li>


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

                  


                  
                   
                    @endif
                    @endif


                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- sidebar menu area end -->