<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{url('admin/dashboard')}}" class="logo">
                <img src="{{asset('logo.jpg')}}" alt="navbar brand" class="navbar-brand h-70 mt-3 ms-1" height="70px" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item active">
                    <a  href="{{url('admin/dashboard')}}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                        <span class="caret"></span>
                    </a>
                    
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Components</h4>
                </li>
                {{-- <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#base">
                        <i class="fas fa-layer-group"></i>
                        <p> Practice Area</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="components/avatars.html">
                                    <span class="sub-item">Practice Area 1</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="sub-item">Practice Area 2</span>
                                </a>
                            </li>


                        </ul>
                    </div>
                </li> --}}
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#case">
                        <i class="fas fa-layer-group"></i>
                        <p>Cases</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="case">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{route('admin.customer-cases')}}">
                                    <span class="sub-item">List</span>
                                </a>
                            </li>
                            {{-- <li>
                                <a href="#">
                                    <span class="sub-item">Case 2</span>
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                </li>
              

         <li class="nav-item">
          <a data-bs-toggle="collapse" href="#lawyer" role="button" aria-expanded="false" aria-controls="lawyer">
              <i class="fa fa-legal" style="font-size:20px;color: #c7bfbf"></i>
              <p>Lawyer</p>
              <span class="caret"></span>
          </a>
          <div class="collapse" id="lawyer">
              <ul class="nav nav-collapse">
                  <li>
                      <a href="{{ route('admin.lawyers') }}">
                          <span class="sub-item"><i class='far fa-address-card' style="color: #c7bfbf"></i> List</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('admin.lawyers.proficience') }}">
                          <span class="sub-item"><i class='fas fa-graduation-cap' style="color: #c7bfbf"></i> Proficience</span>
                      </a>
                  </li>
              </ul>
          </div>
      </li>
      


                <li class="nav-item">
                    <a href="{{ route('admin.customer.detail') }}">
                        <i class="fas fa-user"></i>
                        <p>Customer</p>

                    </a>
                </li>
                <li class="nav-item">
                  <a data-bs-toggle="collapse" href="#subscription">
                      <i class="fa fa-shopping-bag" style="font-size:20px;color: #c7bfbf"></i>
                      <p>Subscription</p>
                      <span class="caret"></span>
                  </a>
                  <div class="collapse" id="subscription">
                      <ul class="nav nav-collapse">
                          <li>
                              <a href="#">
                                  <span class="sub-item"><i class='fa fa-tasks'
                                          style="color: #c7bfbf"></i>List</span>
                              </a>
                          </li>
                          <li>
                              <a href="{{ route('admin.subscription.feature') }}">
                                  <span class="sub-item"><i class='fa fa-gears'
                                          style="color: #c7bfbf"></i>Feature</span>
                              </a>
                          </li>
                      </ul>
                  </div>
              </li>
                <li class="nav-item">
                    <a href="{{route('work-in-progress')}}">
                        <i class="fas fa-user"></i>
                        <p>Transaction</p>

                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('work-in-progress')}}">
                        <i class="fas fa-user"></i>
                        <p>FeedBack</p>

                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.notification.show') }}">
                        <i class="fas fa-bell"></i>
                        <p>Push Notification</p>

                    </a>
                </li>
                <li class="nav-item">
                  <a data-bs-toggle="collapse" href="#faq">
                      <i class="fa fa-question-circle" style="font-size:20px;color: #c7bfbf"></i>
                      <p>FAQ</p>
                      <span class="caret"></span>
                  </a>
                  <div class="collapse" id="faq">
                      <ul class="nav nav-collapse">
                          <li>
                              <a href="{{route('admin.faq.category')}}">
                                  <span class="sub-item"><i class='fa fa-list-alt'
                                          style="color: #c7bfbf"></i>Category</span>
                              </a>
                          </li>
                          <li>
                              <a href="{{route('admin.faq.question')}}">
                                  <span class="sub-item"><i class='fa fa-question'
                                          style="color: #c7bfbf"></i>Question</span>
                              </a>
                          </li>
                      </ul>
                  </div>
              </li>

                <li class="nav-item">
                    <a href="{{ route('admin.welcome.message') }}">
                        <i class="fas fa-bell"></i>
                        <p> Welcome Message</p>

                    </a>
                </li>


                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#charts">
                        <i class="fas fa-user"></i>
                        <p>Users</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="charts">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('admin.user-list') }}">
                                    <span class="sub-item"><i class="far fa-user"></i>UserList</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.role-permission-list') }}">

                                    <span class="sub-item"><i class="far fa-id-badge"></i>Role & Permission</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>



          
            </ul>
        </div>
    </div>
</div>
