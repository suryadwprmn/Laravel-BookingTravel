<!doctype html>
<html>
<head>
    <title>Sign In</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ asset('output.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
</head>
<body class="font-poppins text-black">
    <section class="min-h-screen bg-blue w-full">
        <!-- Main container with max-width for larger screens -->
        <div class="container mx-auto min-h-screen">
            <!-- Flex container for side-by-side layout -->
            <div class="min-h-screen flex flex-col lg:flex-row items-center justify-center gap-8 px-4 py-[46px] lg:px-8">
                <!-- Image container -->
                <div class="w-full lg:w-1/2 max-w-[640px]">
                    <div class="rounded-[20px] overflow-hidden">
                        <img src="assets/backgrounds/Asset.png" class="w-full h-full object-cover" alt="background">
                    </div>
                </div>
                
                <!-- Form container -->
                <div class="w-full lg:w-1/2 max-w-[640px] flex justify-center">
                    <form method="POST" action="{{ route('login') }}" class="w-full max-w-[480px] bg-white p-8 gap-8 rounded-[22px] flex flex-col items-center">
                        @csrf
                        <div class="flex flex-col gap-1 text-center w-full">
                            <h1 class="font-semibold text-2xl lg:text-3xl leading-[42px]">Sign In</h1>
                            <p class="text-sm lg:text-base leading-[25px] tracking-[0.6px] text-darkGrey">Welcome Back! Enter your valid data</p>
                        </div>
                        
                        <div class="flex flex-col gap-[15px] w-full">
                            <div class="flex flex-col gap-1 w-full">
                                <p class="font-semibold">Email</p>
                                <div class="flex items-center gap-3 p-[16px_12px] border border-[#BFBFBF] rounded-xl focus-within:border-[#4D73FF] transition-all duration-300">
                                    <div class="w-4 h-4 flex shrink-0">
                                        <img src="assets/icons/sms.svg" alt="icon">
                                    </div>
                                    <input type="email" class="appearance-none outline-none w-full text-sm lg:text-base placeholder:text-[#BFBFBF] tracking-[0.35px]" placeholder="Your email address" name="email" value="{{ old('email') }}" required autofocus>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>
                            
                            <div class="flex flex-col gap-1 w-full">
                                <p class="font-semibold">Password</p>
                                <div class="flex items-center gap-3 p-[16px_12px] border border-[#BFBFBF] rounded-xl focus-within:border-[#4D73FF] transition-all duration-300">
                                    <div class="w-4 h-4 flex shrink-0">
                                        <img src="assets/icons/password-lock.svg" alt="icon">
                                    </div>
                                    <input type="password" class="appearance-none outline-none w-full text-sm lg:text-base placeholder:text-[#BFBFBF] tracking-[0.35px]" placeholder="Enter your valid password" name="password" required>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="bg-[#4D73FF] p-[16px_24px] min-w-14 rounded-[10px] text-center text-white font-semibold hover:bg-[#06C755] transition-all duration-300">
                            Sign In
                        </button>
                        
                        <p class="text-center text-sm lg:text-base tracking-[0.35px] text-darkGrey">
                            Don't have account? <a href="{{ route('register') }}" class="text-[#4D73FF] font-semibold tracking-[0.6px]">Sign Up</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
