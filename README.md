
This code simply shows how you can reset passowd in laravel by sending the a link to the email address.
Create ForgotPassword Controller and paste the following code.
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\User;
use Mail;
use Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    //
    public function showForgetPasswordForm()
    {
        return view('auth.forgetPassword');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email'=>'required|email|exists:users'
        ]);
        $token=Str::random(64);
        DB::table('password_resets')->insert([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=>Carbon::now()
        ]);
          Mail::send('email.forgetPassword',['token'=>$token],function ($message) use($request){
            $message->to($request->email);
            $message->subject('Reset-Password');
        });
        return back()->with(['message'=>'we have email your password reset link']);

    }

    public function showResetPasswordForm($token)
    {
        return view('auth.forgetPasswordLink',['token'=>$token]);

    }
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email'=>'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        $updatePassword= DB::table('password_resets')
        ->where([
          'email' => $request->email,
          'token' => $request->token
        ])
 ->first();
        $user=User::where('email',$request->email)
                ->update([
                    'password'=>Hash::make($request->password)
                ]);
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        return redirect('/login')->with('message', 'Your password has been changed!');


    }
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        $verify=User::where('email',$request->email && 'password',$request->password)
        
         return $verify;
        if($verify='NULL')
        {
            return response()->json('message','no such user');
        }

    }
}
                                                    
           
           
 2.Create the blade templates
 * check the resource/views(copy all the files)

3.Configure the .env environment as shown
MAIL_DRIVER = smtp
MAIL_HOST = smtp.googleemail.com
MAIL_PORT = 465
MAIL_USERNAME = your email address
MAIL_PASSWORD = your password
MAIL_ENCRYPTION = ssl

4.Enable the Less secure app access in gmail.
