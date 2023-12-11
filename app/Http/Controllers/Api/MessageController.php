<?php

namespace App\Http\Controllers\Api;
use App\Models\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     ** @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'name' => 'required',
            'text' => 'required',
        ];
        $customMessages = [
            'email.required' => 'Il campo E-mail è obbligatorio.',
            'email.email' => 'Inserisci un indirizzo email valido.',
            'name.required' => 'Il campo Nome è obbligatorio.',
            'text.required' => 'Il campo Messaggio è obbligatorio.',
        ];
        $validator = Validator::make($request->input('params'), $rules,$customMessages);

        if ($validator->fails()) {
            // Restituisci una risposta JSON contenente i messaggi di errore
            return response()->json(['errors' => $validator->errors()]);
        }
    
        $message= new Message;
        $data=$request->input('params');

        $message->house_id = $data['house_id'];
        $message->email = $data['email'];
        $message->name = $data['name'];
        $message->text = $data['text'];
    
        $message->save();
    


            
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}