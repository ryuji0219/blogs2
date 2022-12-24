
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3>ブログ作成フォーム</h3>
        {{-- <p>ユーザ名：{{$user->name}}</p> --}}
        <form method="POST" action="{{ route('BlogStore') }}" onSubmit="return checkSubmit()">
        @csrf
            <input type="hidden" name="user_id">
            {{-- <input type="hidden" name="user_id" value="{{ $user->id }}"> --}}
            <div class="form-group">
                <label for="title">
                    タイトル
                </label>
                <input
                    id="title"
                    name="title"
                    class="form-control"
                    value="{{ old('title') }}"
                    type="text"
                >
                {{-- @if ($errors->has('title'))
                    <div class="text-danger">
                        {{ $errors->first('title') }}
                    </div>
                @endif --}}
            </div>
            <div class="form-group">
                <label for="content">
                    本文
                </label>
                <textarea
                    id="content"
                    name="content"
                    class="form-control"
                    rows="4"
                >{{ old('content') }}</textarea>
                {{-- @if ($errors->has('content'))
                    <div class="text-danger">
                        {{ $errors->first('content') }}
                    </div>
                @endif --}}
            </div>
            <div class="mt-5">
                <a class="btn btn-secondary" data-dismiss="modal">キャンセル</a>
                <button type="submit" class="btn btn-primary">投稿する</button>
            </div>
        </form>
    </div>
</div>
<script>
function checkSubmit(){
if(window.confirm('投稿してよろしいですか？')){
    return true;
} else {
    return false;
}
}
</script>
