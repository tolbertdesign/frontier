<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Response\Json;
use App\Entities\AccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ReportController extends Controller
{
    const TK_REPORT_PATH_CLASS_PLEDGE = 'api/report/class-pledges';

    public function getClassPledgeUrl()
    {
        $url = null;
        $user = Auth::user();
        $tokenObj = $user->createAccessToken(null, 1);
        $teacherParticipant = $user->teacherParticipant();

        if ($tokenObj && $teacherParticipant) {
            $url = $this->getTkReportUrl(self::TK_REPORT_PATH_CLASS_PLEDGE);
            $program = $teacherParticipant->getProgram();
            $classroom = $teacherParticipant->classroom->first();

            if ($program && $classroom) {
                $urlParams = [
                    $user->id,
                    $tokenObj->access_token,
                    $program->id,
                    $classroom->id
                ];

                $url = $url . '/' . implode('/', $urlParams);
            }
        }

        if (isset($url)) {
            return Json::asSuccess(['url' => $url]);
        } else {
            return Json::asError();
        }
    }

    private function getTkReportUrl($routePath)
    {
        return secure_url(Config::get('booster.trapper_url') . '/' . $routePath);
    }
}
