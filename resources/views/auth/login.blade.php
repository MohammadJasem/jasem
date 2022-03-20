<x-master>
    @section('title', 'Login')
    <div class="container mx-auto flex justify-center">
        <div class="px-12 py-4 bg-gray-200 border border-gray-400 rounded-lg">
            <div class="col-md-8">
                <form id="login-form">
                    @csrf
    
                    <div class="mb-8">
                        <label for="email"
                               class="block mb-2 uppercase font-bold text-xs text-gray-700">
                            Email
                        </label>
                        <input class="border border-gray-400 p-2 w-full"
                               type="email"
                               name="email"
                               id="email"
                               required
                        >
                    </div>
    
                    <div class="mb-8">
                        <label for="password"
                               class="block mb-2 uppercase font-bold text-xs text-gray-700">
                            Password
                        </label>
                        <input class="border border-gray-400 p-2 w-full"
                               type="password"
                               name="password"
                               id="password"
                               required
                        >
                    </div>
    
                    <div>
                        <button type="button" id="login"
                                class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500 mr-2"
                        >
                            Login
                        </button>
                        <div id="messages"></div>
                </form>
            </div>
        </div>
    </div>
    </x-master>
    <script>
        $( document ).ready(function(){
            $('#login').click(function(){
                axios.post(
                "{{env('API_URL')}}/login",
                {
                    email: $('#email').val(),
                    password: $('#password').val(),
                },
                {
                    headers: {
                    "Content-type": "application/json; charset=UTF-8",
                    }
                }
                ).then(function (response) {
                })
                .catch(function (error) {
                });
            })
        })
    </script>
    