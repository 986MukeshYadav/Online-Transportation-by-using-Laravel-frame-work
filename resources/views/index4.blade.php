<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href='https://fonts.googleapis.com/css?family=Stardos Stencil' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./Sign in/Sign up/register2.css" type="text/css">
</head>

<body>

    <div id="container">

        <div id="wrapper">
            <div id="headwrap">
                <div id="header">R E G I S T E R</div>
            </div>
            <form id="valForm" method="POST" action=" {{url('/')}}/index4">
                @csrf
                <div class="field">
                    <label>Name:</label>
                    <input type="text" id="name" name="name" class="input" >
                    <div id="check" class="check"></div>
                    <span style="color:red">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>


                <div class="field">
                    <label>City:</label>
                    <input type="text" id="ci" name="city" class="input" >
                    <div id="check3" class="check"></div>

                    <span class="text-danger">
                        @error('city')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="field">
                    <label>country:</label>
                    <select id="co" name="country" class="input" type="text" >
                        <option value="0"> -- Select country -- </option>
                        <option value="Nepal">Nepal</option>
                        <option value="India">India</option>
                        <option value="Bhutan">Bhutan</option>
                        <option value="Bangaldesh">Bangaldesh</option>
                      
                    </select>
                    <div id="check4" class="check"></div>
                    <span class="text-danger">
                        @error('co')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="field">
                    <label>E-mail:</label>
                    <input type="text" id="em" name="email" class="input">
                    <div id="check5" class="check"></div>

                    <span class="text-danger">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </span>
                </div>

                <div class="field">
                    <label>Password:</label>
                    <input type="password" id="pswd" name="password" class="input pswd pass" ><i
                        class="fa fa-eye-slash" id="eye"></i>

                    <span class="text-danger">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </span>
                </div>


                <div id="bottomdiv">
                    <button type="submit" id="submit" value="submit" class="btn" name="submit"><span
                            id="submit">&#9472; submit &#9472;</span></button>
                </div>&#26;
            </form>
        </div>
    </div>
    <!-- The Modal (no interaction with the rest of the page is possible until the user closes it!)-->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="close">&times;</div>
            <p class="text">Thank you, for filling in the form.</p>
        </div>

    </div>

    <script src="register2.js"></script>
</body>

</html>


{{-- Controller --}}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Index4;
class index4Controller extends Controller
{
    public function index()
    {
        $url =url('/index4');
        $title="Register Information";
        $register=New Index4();  
        $data=compact('url','title','register');    
        return view('index4')->with($data);
    }

    public function register(Request $request)
    {
        $request->validate(
            [
             "name" => "required",
             "city" => "required",
             "email" => "required|email",
             "country" => "required",
             "password" => "required",
             
            ]
            );
           
            $register = new Index4;
            $register->name=$request['name'];
            $register->city=$request['city'];
            $register->email=$request['email'];
            $register->country=$request['country'];
            $register->password=$request['password'];
            $register -> save();
            echo "<pre>";
            print_r($request->all());
            return redirect ('/index4/view');


    }
    public function view()
    {
    $registers = Index4::all();
    $data=compact('registers');
    return view('register_view')->with($data);
    }



    public function edit($id)
    {
        $register = Index4::find($id);
        if (is_null($register)){
            return redirect ('index4/view');
           }

           else{
            $url =url('/index4/update')."/".$id;
        $title="Update Information";
       
        $data=compact('url','title','register');    
        return view('editform')->with($data);
           }
    }

    public function update($id,Request $request)
    {
            $register = Index4::find($id);
            $register->name=$request['name'];
            $register->city=$request['city'];
            $register->email=$request['email'];
            $register->country=$request['country'];
            $register->password=$request['password'];
        $register ->save();
        return redirect ('/index4/view');
    }

    public function delete($id)
    {
       $register = Index4::find($id);
       if (!is_null($register)){
        $register->delete();
       }
       return redirect('/index4/view');
    }

public function create()
{
    $url=url('/update');
    $data =compact('url');
    return view('editform')->with($data);

}


}


// routefile

<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\AboutLicense;
use App\Http\Controllers\Index1Controller;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\penlatiesController;
use App\Http\Controllers\index4Controller;
use App\Http\Controllers\index3Controller;
use App\Models\Index4;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',function(){
    return view('welcome');
});

 Route::get('/index',function(){
    return view('index');
 });




Route::get('/index2',function(){
    return view('index2');
});

Route::get('/index3',function(){
    return view('index3');
});


Route::get('/gallery',function(){
    return view('Gallery');
});


Route::get('/about',function(){
    return view('About_License');
});


Route::get('/contact',[ContactController::class, 'index']);
Route::post('/contact',[ContactController::class, 'register']);

Route::get('/vehicle',[VehicleController::class, 'index']);
Route::post('/vehicle',[VehicleController::class, 'register']);

Route::get('/penlaties',[penlatiesController::class, 'index']);
Route::post('/penlaties',[penlatiesController::class, 'register']);


Route::get('/index1',[index1Controller::class, 'index']);
Route::post('/index1',[index1Controller::class, 'register']);

Route::get('/index4',[index4Controller::class, 'index']);
Route::post('/index4',[index4Controller::class, 'register']);
Route::get('/index4/view',[index4Controller::class, 'view']);

Route::get('/index4/create',[index4Controller::class, 'create']);

Route::get('/index4/edit/{id}',[index4Controller::class, 'edit']);
Route::post('/index4/update/{id}',[index4Controller::class, 'update']);
Route::get('/index4/delete/{id}',[index4Controller::class, 'delete'])->name('index4.delete');





Route::get('/index3',[index3Controller::class, 'index']);
Route::post('/index3',[index3Controller::class, 'register']);


Route::get('/index4',function(){
    return view('index4');
});

