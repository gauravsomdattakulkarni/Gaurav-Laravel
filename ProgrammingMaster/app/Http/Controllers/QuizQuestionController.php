<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\EncryptionModel;
use App\Models\Admin;
use App\Models\Book;
use App\Models\BookQuantity;
use App\Models\Quiz;
use App\Models\QuizQuestions;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Throwable;

date_default_timezone_set('Asia/kolkata');


class QuizQuestionController extends Controller
{
    protected $EncryptionModel;
    protected $Quiz;

    public function __construct(EncryptionModel $EncryptionModel , Quiz $Quiz)
    {
        $this->EncryptionModel = $EncryptionModel;
        $this->Quiz = $Quiz;
    }


    public function manage_quiz_questions($base_64_quiz_id , Request $request)
    {

        $enc_quiz_id = base64_decode($base_64_quiz_id);
        $quiz_id =$this->EncryptionModel->decrypt($enc_quiz_id);

        $quizDetails = Quiz::where('quiz_id','=',$quiz_id)->get();
        if ($quizDetails->count() == 0)
        {
            $request->session()->flash('errortitle', "Error !");
            $request->session()->flash('errormessage', "Quiz Details Not Found");
            return redirect('manage_quiz');
        }
        else
        {
            $quiz_question_details = QuizQuestions::where('quiz_id','=',$quiz_id)->get();
            $data['quiz_question_details'] = $quiz_question_details;
            $data['base_64_quiz_id'] = $base_64_quiz_id;
            $data['quiz_details'] = $quizDetails;
            return view('admin.quiz_questions.manage_quiz_questions', $data);
        }
    }

    public function add_quiz_questions($base_64_quiz_id , Request $request){
        $enc_quiz_id = base64_decode($base_64_quiz_id);
        $quiz_id =$this->EncryptionModel->decrypt($enc_quiz_id);

        $quizDetails = Quiz::where('quiz_id','=',$quiz_id)->get();
        if ($quizDetails->count() == 0)
        {
            $request->session()->flash('errortitle', "Error !");
            $request->session()->flash('errormessage', "Quiz Details Not Found");
            return redirect('manage_quiz');
        }
        else
        {
            $data['base_64_quiz_id'] = $base_64_quiz_id;
            $data['quiz_details'] = $quizDetails;
            return view('admin.quiz_questions.add_quiz_questions', $data);
        }
    }

    public function add_quiz_question_success(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,quiz_id',
            'topic_name' => 'required|string|max:255',
            'question' => 'required|string',
            'option_1' => 'required|string|max:255',
            'option_2' => 'required|string|max:255',
            'option_3' => 'required|string|max:255',
            'option_4' => 'required|string|max:255',
            'correct_answer' => 'required|string',
            'marks' => 'required|numeric|min:1',
            'question_status' => 'required|in:Active,Inactive',
            'question_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'question_description' => 'nullable|string',
            'question_source' => 'nullable|string|max:255',
        ]);

        try {
            // Retrieve input data
            $quiz_id = $request->input('quiz_id');
            $enc_quiz_id = $this->EncryptionModel->encrypt($quiz_id);
            $base_64_quiz_id = base64_encode($enc_quiz_id);
            $topic_name = $request->input('topic_name');
            $question = $request->input('question');
            $option_1 = $request->input('option_1');
            $option_2 = $request->input('option_2');
            $option_3 = $request->input('option_3');
            $option_4 = $request->input('option_4');
            $correct_answer = $request->input('correct_answer');
            $marks = $request->input('marks');
            $question_status = $request->input('question_status');
            $question_description = $request->input('question_description') ?? '-';
            $question_source = $request->input('question_source') ?? '-';


            // Handle optional question image
            $question_image = "NA";
            if ($request->hasFile('question_image')) {
                $image = $request->file('question_image');
                $image_name = 'question_' . time() . '.' . $image->extension();
                $path = './public/assets/questions/';
                $image->move($path, $image_name);
                $question_image = asset('public/assets/questions/' . $image_name);
            }

            // Insert question into database
            $question_data = [
                'quiz_id' => $quiz_id,
                'topic_name' => $topic_name,
                'question' => $question,
                'option_1' => $option_1,
                'option_2' => $option_2,
                'option_3' => $option_3,
                'option_4' => $option_4,
                'correct_answer' => $correct_answer,
                'marks' => $marks,
                'question_status' => $question_status,
                'question_image' => $question_image,
                'question_description' => $question_description,
                'question_source' => $question_source,
            ];

            QuizQuestions::create($question_data);

            $request->session()->flash('successtitle', "Success!");
            $request->session()->flash('successmessage', "Question added successfully to the quiz.");
            return redirect('manage_quiz_questions/' . $base_64_quiz_id);
        } catch (\Exception $e) {
            $request->session()->flash('errortitle', "Error!");
            $request->session()->flash('errormessage', "$e An error occurred while adding the question. Please try again.");
            return redirect('manage_quiz_questions/' . $base_64_quiz_id);
        }
    }

    public function delete_quetion_success(Request $request)
    {
        $question_id = $request->input('question_id_delete');
        $questionDetails = QuizQuestions::where('quiz_question_id', '=', $question_id)->get();

        if ($questionDetails->count() > 0) {
            $quiz_id = $questionDetails[0]->quiz_id;
            $enc_quiz_id = $this->EncryptionModel->encrypt($quiz_id);
            $base_64_quiz_id = base64_encode($enc_quiz_id);
            $delete_question = QuizQuestions::where('quiz_question_id', '=', $question_id)->delete();

            if ($delete_question) {
                $request->session()->flash('successtitle', "Success!");
                $request->session()->flash('successmessage', "Question deleted successfully.");
                return redirect("manage_quiz_questions/$base_64_quiz_id");
            } else {
                $request->session()->flash('errortitle', "Error!");
                $request->session()->flash('errormessage', "Something went wrong, please try again later.");
                return redirect("manage_quiz_questions/$base_64_quiz_id");
            }
        } else {
            $request->session()->flash('errortitle', "Error!");
            $request->session()->flash('errormessage', "Question details not found.");
            return redirect()->back();
        }
    }

    public function edit_quiz_question($question_id)
    {
        try {

            $question = QuizQuestions::where('quiz_question_id','=',$question_id)->get();
            $data['question'] = $question;

            return view('admin.quiz_questions.edit_quiz_question', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'errortitle' => "Error!",
                'errormessage' => "Question not found or an error occurred.",
            ]);
        }
    }

    public function update_quiz_question(Request $request)
    {
       $request->validate([
            'question_id' => 'required',
            'topic_name' => 'required|string|max:255',
            'question' => 'required|string',
            'option_1' => 'required|string|max:255',
            'option_2' => 'required|string|max:255',
            'option_3' => 'required|string|max:255',
            'option_4' => 'required|string|max:255',
            'correct_answer' => 'required|string',
            'marks' => 'required|numeric|min:1',
            'question_status' => 'required',
            'question_status' => 'required',
            'question_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'question_description' => 'nullable|string',
            'question_source' => 'nullable|string|max:255',
        ]);

        try {
            $question = QuizQuestions::findOrFail($request->input('question_id'));

            $question_image_url = $question->question_image;
            if ($request->hasFile('question_image')) {
                $image = $request->file('question_image');
                $image_name = 'question_' . time() . '.' . $image->extension();
                $path = './public/assets/questions/';
                $image->move($path, $image_name);
                $question_image_url = asset('public/assets/questions/' . $image_name);
            }

            $quiz_question_update_details = [
                'topic_name' => $request->input('topic_name'),
                'question' => $request->input('question'),
                'option_1' => $request->input('option_1'),
                'option_2' => $request->input('option_2'),
                'option_3' => $request->input('option_3'),
                'option_4' => $request->input('option_4'),
                'correct_answer' => $request->input('correct_answer'),
                'marks' => $request->input('marks'),
                'question_status' => $request->input('question_status'),
                'question_image' => $question_image_url,
                'question_description' => $request->input('question_description') ?? '-',
                'question_source' => $request->input('question_source') ?? '-',
            ];

            $question->update($quiz_question_update_details);

            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

}
