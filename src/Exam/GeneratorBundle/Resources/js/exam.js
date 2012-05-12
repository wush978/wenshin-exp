var hash = "%hash%";
var Result = new Array(%question_size%);
var Question = new Array(%question_size%);
var question_index = 0;
var question_size = %question_size%;

function nextQuestion() {
  stop();
  played_time = 0;
  question_index++;
  if (question_index < question_size) {
    document.body.innerHTML = Question[question_index];
  }
  else {
    var result = "";
    for(i = 1;i < question_size;i++) {
      result = result + Result[i];
      if (i + 1 < question_size) {
        result = result + ",";
      }
    }
    var fso = new ActiveXObject("Scripting.FileSystemObject");
    var file_name = school + "_" + level + "_" + class_var + "_" + student_id + "_" + hash + ".txt";
    var location = document.URL;
    location = location.slice(7, location.length - 41);
    location = location.concat(file_name);
    var s = fso.CreateTextFile(location, true);
    s.WriteLine(result);
    s.WriteLine(personal_data);
    s.Close();
    document.body.innerHTML = "謝謝你的作答，請將「" + file_name + "」放到老師指定的位置。" ;
  } 
}
function saveResult(result) {
  if(result) {
      Result[question_index] = result;
      nextQuestion();
  }
  else {
    alert("你還沒有做選擇");
  }
}
function retrieveAnswer() {
  var form = document.getElementById("form");
  for (var i = 0;i < form.answer.length;i++) {
    if(form.answer[i].checked) {
      return(form.answer[i].value);
    }
  }
}
var played_time;
function play() {
  if (played_time >= 2) {
    return false;
  }
  played_time++;
  document.embeds[0].stop(); 
  alert("這次是聽第" + played_time + "次喔，總共只能聽兩次");
    document.embeds[0].play(); 
  
  return true;
} 
function stop() {
  if (played_time > 0) {
    document.embeds[0].stop();
  }
}
//%assign_Question%
//%assign_Sound_src%

function debug() {
  alert(document.body.innerHTML.toString());
}

var school;
var level;
var class_var;
var student_id;
var sex;
var is_learned_music;
var start_music_year_old;
var music_subject;
var how_long_learn_music;
var is_join_music_group;
var joined_music_group_name;
var is_join_music_cram_school;
var music_cram_school_name;
var music_cram_school_subject;
var personal_data;
function startTest() {
  school = document.getElementById("input_school").value;
  level = document.getElementById("input_level").value;
  class_var = document.getElementById("input_class").value;
  student_id = document.getElementById("input_student_id").value;
  if (document.getElementById("input_sex_boy").checked) {
    sex = "男生";
  }
  if (document.getElementById("input_sex_girl").checked) {
    sex = "女生";
  }
  if (document.getElementById("is_learned_music_no").checked) {
    is_learned_music = "無";
    start_music_year_old = "NA";
    music_subject = "NA";
    how_long_learn_music = "NA";
  }
  if (document.getElementById("is_learned_music_yes").checked) {
    is_learned_music = "有";
    start_music_year_old = document.getElementById("input_start_music_year_old").value;
    music_subject = document.getElementById("input_music_subject").value;
    if (document.getElementById("input_how_long_learn_music1").checked) {
      how_long_learn_music = "0-0.5";
    }
    if (document.getElementById("input_how_long_learn_music2").checked) {
      how_long_learn_music = "0.5-1";
    }
    if (document.getElementById("input_how_long_learn_music3").checked) {
      how_long_learn_music = "1-2";
    }
    if (document.getElementById("input_how_long_learn_music4").checked) {
      how_long_learn_music = "2-3";
    }
  }
  if (document.getElementById("input_is_join_music_group_no").checked) {
    is_join_music_group = "無";
    joined_music_group_name = "NA";
  }
  if (document.getElementById("input_is_join_music_group_yes").checked) {
    is_join_music_group = "有";
    joined_music_group_name = document.getElementById("input_joined_music_group_name").value;
  }
  if (document.getElementById("input_is_join_music_cram_school_no").checked) {
    is_join_music_cram_school = "無參加課外自費音樂課程";
    music_cram_school_name = "NA";
    music_cram_school_subject = "NA";
  }
  if (document.getElementById("input_is_join_music_cram_school_yes_group").checked) {
    is_join_music_cram_school = "有參加課外自費音樂團體課程";
    music_cram_school_name = document.getElementById("input_music_cram_school_name").value;
    music_cram_school_subject = "NA";
  }
  if (document.getElementById("input_is_join_music_cram_school_yes_single").checked) {
    is_join_music_cram_school = "有參加課外自費音樂家教";
    music_cram_school_name = "NA";
    music_cram_school_subject = document.getElementById("input_music_cram_school_subject").value;
  }
  personal_data = '1.國小:' + level +
    '年級:' + level +
    '班級:' + class_var +
    '座號:' + student_id + '<br/>' + 
    '<hr/>'+
    '2.性別:' + sex + '<br/><hr/>' +
    '3.' + is_learned_music + '學過獨奏樂器<br/>' + 
    '從' + start_music_year_old + '歲開始,' +
    '樂器名稱: ' + music_subject + '<br/>' +
    '學了' + how_long_learn_music + '年<br/><hr/>' +
    '4.' + is_join_music_group + '參加過或目前正參加學校音樂性社團<br/>' +
    '名稱:' + joined_music_group_name + '<br/><hr/>' +
    '5.' + is_join_music_cram_school + '<br/>' +
    '課程名稱: ' + music_cram_school_name + '<br/>' +
    '家教名稱: ' + music_cram_school_subject + '<br/><hr/>' +
    '<input type="button" onclick="nextQuestion()" value="資料正確"/><input type="button" onclick="beginPage()" value="資料錯誤，我要重新輸入"/>';   
  document.body.innerHTML = personal_data;  
}

function beginPage() {
  document.body.innerHTML = '1.國小:<input id="input_school" type="text"/>' +
    '年級:<input id="input_level" type="text"/>' +
    '班級:<input id="input_class" type="text"/>' +
    '座號:<input id="input_student_id" type="text"/><br/>' + 
    '<hr/>'+
    '2.性別:<br/><input type="radio" name="input_sex" value="boy" id="input_sex_boy">男生</input>' +
    '<input type="radio" name="input_sex" value="girl" id="input_sex_girl">女生</input><br/><hr/>' +
    '3.請問你曾經學過或目前正在學獨奏樂器嗎?<br/>' + 
    '<input type="radio" name="input_is_learned_music" value="no" id="is_learned_music_no">無</input>(請跳答第4題)<br/>' +
    '<input type="radio" name="input_is_learned_music" value="yes" id="is_learned_music_yes">有</input>, ' +
    '我從<input id="input_start_music_year_old" type="text"/>歲開始,' +
    '樂器名稱: <input id="input_music_subject" type="text"/><br/>' +
    '學了多久?<br/>' +
    '<input type="radio" name="input_how_long_learn_music" value="0-0.5" id="input_how_long_learn_music1">半年以內</input><br/>' +
    '<input type="radio" name="input_how_long_learn_music" value="0.5-1" id="input_how_long_learn_music2">半年到一年</input><br/>' +
    '<input type="radio" name="input_how_long_learn_music" value="1-2" id="input_how_long_learn_music3">一年到兩年</input><br/>' +
    '<input type="radio" name="input_how_long_learn_music" value="2-3" id="input_how_long_learn_music4">兩年到三年</input><br/><hr/>' +
    '4.你是否參加過或目前正參加學校音樂性社團？(例如：合唱團、節奏樂隊、管樂團、國樂團、節令鼓)<br/>' +
    '<input type="radio" name="input_is_join_music_group" value="no" id="input_is_join_music_group_no">無</input><br/>' +
    '<input type="radio" name="input_is_join_music_group" value="yes" id="input_is_join_music_group_yes">有</input>, ' +
    '名稱:<input type="text" id="input_joined_music_group_name"/><br/><hr/>' +
    '5.你是否參加過或目前仍參加課外自費的音樂課程?<br/>' +
    '<input type="radio" name="input_is_join_music_cram_school" value="no" id="input_is_join_music_cram_school_no">無</input><br/>' +
    '<input type="radio" name="input_is_join_music_cram_school" value="yes_group" id="input_is_join_music_cram_school_yes_group">有</input>, ' +
    '音樂團體課，例如「山葉團體鍵盤課」、「朱宗慶打擊樂團」等…<br/>' +
    '(請說明課程名稱: <input type="text" id="input_music_cram_school_name"/>)<br/>' +
    '<input type="radio" name="input_is_join_music_cram_school" value="yes_single" id="input_is_join_music_cram_school_yes_single">有</input>, ' +
    '音樂家教，例如鋼琴、小提琴、長笛、吉他等…<br/>' +
    '(請說明課程名稱: <input type="text" id="input_music_cram_school_subject"/>)<br/><hr/>' +
    '<input type="button" onclick="startTest()" value="開始作答"/>';    
}