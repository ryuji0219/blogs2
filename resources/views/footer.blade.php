<div class="container text-center">
    @if (isset($user['name']))
        <a class="nav-item nav-link" href="{{route('DeleteUser')}}"
        onClick="checkSubmit_retire();return false;">退会<span class="sr-only"></span></a>
    @else
        <a class="nav-item nav-link"><span class="sr-only"></span></a>
    @endif
</div>
<script>
function checkSubmit_retire(){
    if(window.confirm('退会してよろしいですか？')){
        return true;
    } else {
        return false;
    }
}
</script>
