<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.0/css/boxicons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">


<style>
    /* Table CSS */
    body {
        background: #f7f7f7;
    }

    .table {
        border-spacing: 0 0.85rem !important;
    }

    .table .dropdown {
        display: inline-block;
    }

    .table td,
    .table th {
        vertical-align: middle;
        margin-bottom: 10px;
        border: none;
    }

    .table thead tr,
    .table thead th {
        border: none;
        font-size: 12px;
        letter-spacing: 1px;
        text-transform: uppercase;
        background: transparent;
    }

    .table td {
        background: #fff;
    }

    .table td:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .table td:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .avatar {
        width: 2.75rem;
        height: 2.75rem;
        line-height: 3rem;
        border-radius: 50%;
        display: inline-block;
        background: transparent;
        position: relative;
        text-align: center;
        color: #868e96;
        font-weight: 700;
        vertical-align: bottom;
        font-size: 1rem;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .avatar-sm {
        width: 2.5rem;
        height: 2.5rem;
        font-size: 0.83333rem;
        line-height: 1.5;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        -o-object-fit: cover;
        object-fit: cover;
    }

    .avatar-blue {
        background-color: #c8d9f1;
        color: #467fcf;
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td:first-child:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>th:first-child:before {
        top: 28px;
        left: 14px;
        border: none;
        box-shadow: none;
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td:first-child,
    table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>th:first-child {
        padding-left: 48px;
    }

    table.dataTable>tbody>tr.child ul.dtr-details {
        width: 100%;
    }

    table.dataTable>tbody>tr.child span.dtr-title {
        min-width: 50%;
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr>td.child,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th.child,
    table.dataTable.dtr-inline.collapsed>tbody>tr>td.dataTables_empty {
        padding: 0.75rem 1rem 0.125rem;
    }

    div.dataTables_wrapper div.dataTables_length label,
    div.dataTables_wrapper div.dataTables_filter label {
        margin-bottom: 0;
    }

    @media (max-width: 767px) {
        div.dataTables_wrapper div.dataTables_paginate ul.pagination {
            -ms-flex-pack: center !important;
            justify-content: center !important;
            margin-top: 1rem;
        }
    }

    .btn-icon {
        background: #fff;
    }

    .btn-icon .bx {
        font-size: 20px;
    }

    .btn .bx {
        vertical-align: middle;
        font-size: 20px;
    }

    .dropdown-menu {
        padding: 0.25rem 0;
    }

    .dropdown-item {
        padding: 0.5rem 1rem;
    }

    .badge {
        padding: 0.5em 0.75em;
    }

    .badge-success-alt {
        background-color: #d7f2c2;
        color: #7bd235;
    }

    .table a {
        color: #212529;
    }

    .table a:hover,
    .table a:focus {
        text-decoration: none;
    }

    table.dataTable {
        margin-top: 12px !important;
    }

    .icon>.bx {
        display: block;
        min-width: 1.5em;
        min-height: 1.5em;
        text-align: center;
        font-size: 1.0625rem;
    }

    .btn {
        font-size: 0.9375rem;
        font-weight: 500;
        padding: 0.5rem 0.75rem;
    }

    .avatar-blue {
        background-color: #c8d9f1;
        color: #467fcf;
    }

    .avatar-pink {
        background-color: #fcd3e1;
        color: #f66d9b;
    }

    /* Table CSS */
    /*----------bootstrap-navbar-css------------*/
    .navbar-logo {
        padding: 15px;
        color: #fff;
    }

    .navbar-mainbg {
        background-color: #405189;
        padding: 0px;
    }

    #navbarSupportedContent {
        overflow: hidden;
        position: relative;
    }

    #navbarSupportedContent ul {
        padding: 0px;
        margin: 0px;
    }

    #navbarSupportedContent ul li a i {
        margin-right: 10px;
    }

    #navbarSupportedContent li {
        list-style-type: none;
        float: left;
    }

    #navbarSupportedContent ul li a {
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        font-size: 15px;
        display: block;
        padding: 20px 20px;
        transition-duration: 0.6s;
        transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
        position: relative;
    }

    #navbarSupportedContent>ul>li.active>a {
        color: #5161ce;
        background-color: transparent;
        transition: all 0.7s;
    }

    #navbarSupportedContent a:not(:only-child):after {
        content: "\f105";
        position: absolute;
        right: 20px;
        top: 10px;
        font-size: 14px;
        font-family: "Font Awesome 5 Free";
        display: inline-block;
        padding-right: 3px;
        vertical-align: middle;
        font-weight: 900;
        transition: 0.5s;
    }

    #navbarSupportedContent .active>a:not(:only-child):after {
        transform: rotate(90deg);
    }

    .hori-selector {
        display: inline-block;
        position: absolute;
        height: 100%;
        top: 0px;
        left: 0px;
        transition-duration: 0.6s;
        transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
        background-color: #fff;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        margin-top: 10px;
    }

    .hori-selector .right,
    .hori-selector .left {
        position: absolute;
        width: 25px;
        height: 25px;
        background-color: #fff;
        bottom: 10px;
    }

    .hori-selector .right {
        right: -25px;
    }

    .hori-selector .left {
        left: -25px;
    }

    .hori-selector .right:before,
    .hori-selector .left:before {
        content: "";
        position: absolute;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #405189;
    }

    .hori-selector .right:before {
        bottom: 0;
        right: -25px;
    }

    .hori-selector .left:before {
        bottom: 0;
        left: -25px;
    }

    @media (min-width: 992px) {
        .navbar-expand-custom {
            -ms-flex-flow: row nowrap;
            flex-flow: row nowrap;
            -ms-flex-pack: start;
            justify-content: flex-start;
        }

        .navbar-expand-custom .navbar-nav {
            -ms-flex-direction: row;
            flex-direction: row;
        }

        .navbar-expand-custom .navbar-toggler {
            display: none;
        }

        .navbar-expand-custom .navbar-collapse {
            display: -ms-flexbox !important;
            display: flex !important;
            -ms-flex-preferred-size: auto;
            flex-basis: auto;
        }
    }

    @media (max-width: 991px) {
        #navbarSupportedContent ul li a {
            padding: 12px 30px;
        }

        .hori-selector {
            margin-top: 0px;
            margin-left: 10px;
            border-radius: 0;
            border-top-left-radius: 25px;
            border-bottom-left-radius: 25px;
        }

        .hori-selector .left,
        .hori-selector .right {
            right: 10px;
        }

        .hori-selector .left {
            top: -25px;
            left: auto;
        }

        .hori-selector .right {
            bottom: -25px;
        }

        .hori-selector .left:before {
            left: -25px;
            top: -25px;
        }

        .hori-selector .right:before {
            bottom: -25px;
            left: -25px;
        }
    }

    .btn-primary {
        background-color: #405189 !important;
    }

    .clickrow {
        cursor: pointer;
    }

    @media (min-width: 992px) {
        .modal-lg {
            max-width: 1000px !important;
        }
    }

    /* //////////////// */
    .progress-sm {
height: 5px
}

.progress-lg {
height: 12px
}

.progress-xl {
height: 16px
}

.custom-progess {
position: relative
}

.custom-progess .progress-icon {
position: absolute;
top: -12px
}

.custom-progess .progress-icon .avatar-title {
background: var(--vz-secondary-bg)
}

.animated-progress {
position: relative
}

.animated-progress .progress-bar {
position: relative;
border-radius: 6px;
-webkit-animation: animate-positive 2s;
animation: animate-positive 2s
}

@-webkit-keyframes animate-positive {
0% {
    width: 0
}
}

@keyframes animate-positive {
0% {
    width: 0
}
}

.custom-progress {
height: 15px;
padding: 4px;
border-radius: 30px
}

.custom-progress .progress-bar {
position: relative;
border-radius: 30px
}

.custom-progress .progress-bar::before {
content: "";
position: absolute;
width: 4px;
height: 4px;
background-color: #fff;
border-radius: 7px;
right: 2px;
top: 50%;
-webkit-transform: translateY(-50%);
transform: translateY(-50%)
}

.progress-label {
overflow: visible
}

.progress-label .progress-bar {
position: relative;
overflow: visible
}

.progress-label .progress-bar .label {
position: absolute;
top: -25px;
right: -9px;
background-color: #405189;
color: #fff;
display: inline-block;
line-height: 18px;
padding: 0 4px;
border-radius: 4px
}

.progress-label .progress-bar .label:after {
content: "";
position: absolute;
border: 4px solid transparent;
border-top-color: #405189;
bottom: -7px;
left: 50%;
-webkit-transform: translateX(-50%);
transform: translateX(-50%)
}

.progress-step-arrow {
height: 3.25rem
}

.progress-step-arrow .progress-bar {
position: relative;
overflow: initial;
font-size: .875rem;
color: #fff
}

.progress-step-arrow .progress-bar::after {
content: "";
position: absolute;
border: 10px solid transparent;
bottom: 15px;
right: -20px;
z-index: 1
}

.progress-primary .progress-bar {
background-color: #405189
}

.progress-primary .progress-bar::after {
border-left-color: #405189
}

.progress-primary .progress-bar:nth-child(2) {
background-color: rgba(64, 81, 137, .1) !important;
color: #405189 !important
}

.progress-primary .progress-bar:nth-child(2)::after {
border-left-color: rgba(64, 81, 137, .1)
}

.progress-secondary .progress-bar {
background-color: #3577f1
}

.progress-secondary .progress-bar::after {
border-left-color: #3577f1
}

.progress-secondary .progress-bar:nth-child(2) {
background-color: rgba(53, 119, 241, .1) !important;
color: #3577f1 !important
}

.progress-secondary .progress-bar:nth-child(2)::after {
border-left-color: rgba(53, 119, 241, .1)
}

.progress-success .progress-bar {
background-color: #0ab39c
}

.progress-success .progress-bar::after {
border-left-color: #0ab39c
}

.progress-success .progress-bar:nth-child(2) {
background-color: rgba(10, 179, 156, .1) !important;
color: #0ab39c !important
}

.progress-success .progress-bar:nth-child(2)::after {
border-left-color: rgba(10, 179, 156, .1)
}

.progress-info .progress-bar {
background-color: #299cdb
}

.progress-info .progress-bar::after {
border-left-color: #299cdb
}

.progress-info .progress-bar:nth-child(2) {
background-color: rgba(41, 156, 219, .1) !important;
color: #299cdb !important
}

.progress-info .progress-bar:nth-child(2)::after {
border-left-color: rgba(41, 156, 219, .1)
}

.progress-warning .progress-bar {
background-color: #f7b84b
}

.progress-warning .progress-bar::after {
border-left-color: #f7b84b
}

.progress-warning .progress-bar:nth-child(2) {
background-color: rgba(247, 184, 75, .1) !important;
color: #f7b84b !important
}

.progress-warning .progress-bar:nth-child(2)::after {
border-left-color: rgba(247, 184, 75, .1)
}

.progress-danger .progress-bar {
background-color: #f06548
}

.progress-danger .progress-bar::after {
border-left-color: #f06548
}

.progress-danger .progress-bar:nth-child(2) {
background-color: rgba(240, 101, 72, .1) !important;
color: #f06548 !important
}

.progress-danger .progress-bar:nth-child(2)::after {
border-left-color: rgba(240, 101, 72, .1)
}

.progress-light .progress-bar {
background-color: #f3f6f9
}

.progress-light .progress-bar::after {
border-left-color: #f3f6f9
}

.progress-light .progress-bar:nth-child(2) {
background-color: rgba(243, 246, 249, .1) !important;
color: #f3f6f9 !important
}

.progress-light .progress-bar:nth-child(2)::after {
border-left-color: rgba(243, 246, 249, .1)
}

.progress-dark .progress-bar {
background-color: #212529
}

.progress-dark .progress-bar::after {
border-left-color: #212529
}

.progress-dark .progress-bar:nth-child(2) {
background-color: rgba(33, 37, 41, .1) !important;
color: #212529 !important
}

.progress-dark .progress-bar:nth-child(2)::after {
border-left-color: rgba(33, 37, 41, .1)
}

</style>