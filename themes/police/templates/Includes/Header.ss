<header>
    <div class="container">
        <div class="row">
            <div class="col-8 col-sm-10">
                <div class="logo-wrapper clearfix">
                    <img src="/resources/themes/police/images/SoJ-Police-Crest.png" alt="States of Jersey - Police Crest" class="logo" />
                    <div class="title-wrapper">
                        <span class="main-title title">$SiteConfig.Title</span>
                        <span class="sub-title title">$SiteConfig.Tagline</span>
                    </div>
                </div>
            </div>
            <div class="text-right col-4 col-sm-2">
                <% if $CurrentMember %>
                    <a href="/Security/logout?BackURL=%2F" title="Log Out" class="btn btn-primary mt-3">Log Out</a>
                <% else %>
                    <a href="/Security/login?BackURL={$Link}" title="Log In" class="btn btn-primary mt-3">Log In</a>
                <% end_if %>
                
            </div>
        </div>
    </div>
    <nav>
        <div class="container">
            <div class="row">
                <% if $Menu(1) %>
                    <ul class="nav">
                        <% loop $Menu(1) %>
                            <li class="nav-item">
                                <a  class="nav-link<% if $isCurrent || $isSection %> active<% end_if %>" href="{$Link}" title="{$Title}">$MenuTitle</a>
                            </li>
                        <% end_loop %>
                    </ul>
                <% end_if %>
            </div>
        </div>
    </nav>
</header>