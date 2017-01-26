<?php

use Illuminate\Database\Migrations\Migration;
use App\Model\Common\Template;
use App\Model\Common\TemplateType;
use App\Model\Common\TemplateSet;
use Illuminate\Support\Facades\DB;

class CreateSdAddTemplateTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
//        $setid = '1';
//        $sets = new TemplateSet();
//        $types = new TemplateType();
//        $template = new Template();
//        $set = $sets->where('active', 1)->first();
//        if ($set) {
//            $setid = $set->id;
//        }
//        $t = DB::table('template_types')->insertGetId([
//            'name'=>'sd-cab-vote',
//            'created_at'=>date('Y-m-d H:m:i'),
//            'updated_at'=>date('Y-m-d H:m:i'),
//        ]);
        //dd($t);
//        $t = $types->create([
//            'name'=>'sd-cab-vote',
//        ]);
//        DB::table('templates')->insertGetId([
//            'name'=>'sd-cab-vote',
//            'type'=>$t,
//            'message'=>$this->message(),
//            'set_id'=>$setid,
//        ]);
    }
    
    public function message(){
        $message = '<p>Hi&nbsp;{!!$name!!},</p>
                        <p>We need you opinion for an action.</p>
                        <p>Please give your vote and valuable suggestions,</p>
                        <p>For voting please <a href="{!!$system_link!!}">click here</a>.</p>
                        <p>Thank you,</p>
                        <p>{!!$system_from!!}.</p>';
        return $message;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
