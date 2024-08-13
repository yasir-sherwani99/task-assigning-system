<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">babystore</a></li>
                    @if(isset($breadcrumbs['section']))
                        <li class="breadcrumb-item"><a href="#">{{ $breadcrumbs['section'] }}</a></li>
                    @endif
                    <li class="breadcrumb-item active">{{ $breadcrumbs['page'] }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ $breadcrumbs['title'] }}</h4>
        </div><!--end page-title-box-->
    </div><!--end col-->
</div>
<!-- end page title end breadcrumb -->