@include('header')
            <div class = "main border-top">
                @if(session()->has('msgF'))
                <div class = "alert alert-warning">
                    {{session()->get('msgF')}}
                </div>
                @endif
                <h1>Welcome to home page</h1>
            </div>
        </div>
    </body>
</html>
