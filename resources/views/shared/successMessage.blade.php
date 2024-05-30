@if(session("success"))
<!--if the idea controller sets a success key in the session then display the following -->
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{session("success")}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
