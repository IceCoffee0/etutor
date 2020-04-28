<?php
require './functions.php';

function recordActivity($user ,$activity_type, $target = null, $additionalInfo = -1) {
    $current_time = time();
    $query = "INSERT INTO activity_log(user_id, time, activity_id, target, additional_info) VALUES($user, $current_time, $activity_type, '$target', '$additionalInfo')";
    if(!queryMysql($query)) {
        echo "Error occurred";
    }
}

function epochToTime($timeEpoch) {
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    return date("d/m/Y H:i", $timeEpoch);
}

function getActivity_asUser($userId, $limit = 0) {
    if($limit > 0) {
        $query = "SELECT * FROM activity_log WHERE  user_id = '$userId' ORDER BY id DESC LIMIT $limit";
    } else {
        $query = "SELECT * FROM activity_log WHERE user_id = '$userId'";
    }
    $result = queryMysql($query);
    $activities = array();
    while($row = $result->fetch_assoc()) {
        array_push($activities, processActivityLog($row, "user"));
    }
    return $activities;
}

function getActivity_asTarget($targetId, $limit = 0) {
    if($limit > 0) {
        $query = "SELECT * FROM activity_log WHERE target = '$targetId' ORDER BY id DESC LIMIT $limit ";
    } else {
        $query = "SELECT * FROM activity_log WHERE target = '$targetId'";
    }
    $result = queryMysql($query);
    $activities = array();
    while($row = $result->fetch_assoc()) {
        array_push($activities, processActivityLog($row, "target"));
    }
    return $activities;
}

function getAllActivity() {
    $query = "SELECT * FROM activity_log";
    $result = queryMysql($query);
    $activities = array();
    while($row = $result->fetch_assoc()) {
        array_push($activities, processActivityLog($row, "user", true));
    }
    return $activities;
}

function getActivityDetail($activity_id) {
    $query = "SELECT activity_detail FROM activity_type WHERE activity_id = '$activity_id'";
    $result = queryMysql($query);
    return $result->fetch_array()[0];
}

function processActivityLog($row, $type, $manager = false) {
    //var_dump($row);
    $time = epochToTime($row['time']);
    if($type == "user") {
        // initiative 1,2,3,4
        switch ($row['activity_id']):
            case '1':
                $user = getUserFullNameAndId($row['user_id'])[0];
                $activity = getActivityDetail($row['activity_id']);
                $target = getUserFullNameAndId($row['target'])[0];
                $text = "[$time][$user] $activity [Target: $target]";
                return $text;
            case '2':
                $user = getUserFullNameAndId($row['user_id'])[0];
                $activity = getActivityDetail($row['activity_id']);
                $target = explode(",", $row['target']);
                $teacherId = $target[0];
                unset($target[0]);
                $studentIds = implode(",", $target);
                $teacherName = getUserFullNameAndId($teacherId)[0];
                $studentName = implode(",",getUserFullNameAndId($studentIds));
                $text = "[$time][$user] $activity [Teacher: $teacherName][Student(s): $studentName]";
                return $text;
            case '3':
                $user = getUserFullNameAndId($row['user_id'])[0];
                $activity = getActivityDetail($row['activity_id']);
                $target = explode(",", $row['target']);
                $teacherIdOld = $target[0];
                $teacherIdNew = $target[1];
                unset($target[0]);
                unset($target[1]);
                $studentIds = implode(",", $target);
                $teacherOldName = getUserFullNameAndId($teacherIdOld)[0];
                $teacherNewName = getUserFullNameAndId($teacherIdNew)[0];
                $studentName = implode(",",getUserFullNameAndId($studentIds));
                $text = "[$time][$user] $activity [Previous Teacher: $teacherOldName][Current Teacher: $teacherNewName][Student: $studentName]";
                return $text;
            case '4':
                $user = getUserFullNameAndId($row['user_id'])[0];
                $activity = getActivityDetail($row['activity_id']);
                $text = "[$time][$user] $activity";
                return $text;
            case '5':
                
                    $user = getUserFullNameAndId($row['user_id'])[0];
                    $activity = getActivityDetail($row['activity_id']);
                    $smid = $row['additional_info'];
                    $target = getUserFullNameAndId($row['target'])[0];
                    $text = "[$time][$user] $activity [Submittion ID: $smid][Author: $target]";
                    return $text;
                
                break;
            case '6':
                
                    $user = getUserFullNameAndId($row['user_id'])[0];
                    $activity = getActivityDetail($row['activity_id']);
                    $target = getUserFullNameAndId($row['target'])[0];
                    $text = "[$time][$user] $activity [Student: $target]";
                    return $text;
                
                break;
            default:
                echo "Unrecognized activity";
                break;
        endswitch;
    } elseif($type == "target") {
        $time = epochToTime($row['time']);
        // passive 5,6
        switch ($row['activity_id']):
            case '5':
                $user = $user = getUserFullNameAndId($row['user_id'])[0];
                $activity = "Your tutor has left a feedback on your work";
                $workId = $row['additional_info'];
                $text = "[$time] $activity [Submittion ID: $workId]";
                return $text;
            case '6':
                $user = $user = getUserFullNameAndId($row['user_id'])[0];
                $activity = "Your tutor has sent you a document";
                $text = "[$time] $activity";
                return $text;
            default:
                echo "Unrecognized activity";
                break;
        endswitch;
    }
}