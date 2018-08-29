<?php
/**
 * Created by PhpStorm.
 * User: khanhnq16
 * Date: 7/21/14
 * Time: 5:28 PM
 */

abstract class VtCommon{
  const IS_ACTIVE = 1;
  const IS_HOT = 1;
}

abstract class VtUploadFileReportStatusEnum{
  const WAITING = 0; #Chua xu ly
  const PROCESSING = 1; #dang xu ly
  const COMPLETED = 2; #da hoan thanh
  const FAILURE = 3; #that bai
}

abstract class VtFeedBackStatusEnum{
  const UNREAD = 0; #Chua xem
  const VIEWED = 1; #da xem
}

abstract class VtAvatarTypeEnum{
    const SIMPLE = 1;
    const COMPLEX = 0;
}

abstract class VtAvatarOwnerTypeEnum{
  const ADMIN_USER = 1; #loai tai khoan quan tri
  const CP_USER = 2; #loai tai khoan business/brand
  const NORMAL_USER = 3; #loai tai khoan user thuong
}

abstract class VtTopicEnum{
  const NORMAL = 1; #topic thuong
  const CONTEST_BUSINESS = 2; #topic cuoc thi cho doanh nghiep
  const CONTEST_FREESTYLE = 3; #topic cuoc thi tu do
}

abstract class VtGroupTypeEnum{
  const WHITE_LIST = 1;
  const BLACK_LIST = 2;
}

abstract class VtNotificationCaLogEnum{
  const DEACTIVE = 1;
  const DELETE = 2;
  const EXPIRED = 4;
  const OVER_SHOW_REMAIN = 3;
  const INVITE_AVATAR = 5;
}

abstract class VtCmsLogObjectTypeEnum{
  const BUSINESS = 1;
  const BRAND = 2;
  const CAMPAIGN = 3;
}

abstract class VtCmsLogActionEnum{
  const CREATE = 1;
  const DEACTIVE = 2;
  const DELETE = 3;
  const EXPIRED = 4;
}

abstract class VtCategoryEnum{
  const NewCategory='N';
}

abstract class VtCampaignAvatarShowType{
  const WAITING  = "1";
  const DURING_CALL = "2";
  const END_CALL = "3";
}

abstract class VtStatusPhoneNumberRbtServiceEnum {

  const REGISTED = 2;
  const UN_REGISTED = 4;
  const SUSPENDING = 5;
  const BEING_REGISTED = 6;
  const BEING_DELETE_REGISTED = 7;

}

abstract class VtCondTypeEnum{
  const REGION= 1;
  const SEX= 2;
  const AGE= 3;
  const JOB = 4;
  const SALARY= 5;
}

abstract class VtBusinessStatusEnum{

  const NEWCREATE = 0;
  const SHOW = 1;
  const LOCK = 2;
  const DELETED = 3;
}

abstract class VtAvatarStatusEnum{
  const DEACTIVE = 0;
  const ACTIVE = 1;
  const REJECT = 2;
  const VIOLATE = 3;
  const DELETED = 4;
}


abstract class VtBrandStatusEnum{

  const NEWCREATE = 0;
  const SHOW = 1;
  const LOCK = 2;
  const DELETED = 3;
}


abstract class VtCampaignStatusEnum{
  const NEWCREATE = 0;
  const SHOW = 1;
  const LOCK = 2;
  const DELETED = 3;
}


abstract class WorstPass{
  public static $stripTagBr = array(
    "password",
    "12345678",
    "1234",
    "pussy",
    "12345",
    "dragon",
    "qwerty",
    "696969",
    "mustang",
    "letmein",
    "baseball",
    "master",
    "michael",
    "football",
    "shadow",
    "monkey",
    "abc123",
    "pass",
    "fuckme",
    "6969",
    "jordan",
    "harley",
    "ranger",
    "iwantu",
    "jennifer",
    "hunter",
    "fuck",
    "2000",
    "test",
    "batman",
    "trustno1",
    "thomas",
    "tigger",
    "robert",
    "access",
    "love",
    "buster",
    "1234567",
    "soccer",
    "hockey",
    "killer",
    "george",
    "sexy",
    "andrew",
    "charlie",
    "superman",
    "asshole",
    "fuckyou",
    "dallas",
    "jessica",
    "panties",
    "pepper",
    "1111",
    "austin",
    "william",
    "daniel",
    "golfer",
    "summer",
    "heather",
    "hammer",
    "yankees",
    "joshua",
    "maggie",
    "biteme",
    "enter",
    "ashley",
    "thunder",
    "cowboy",
    "silver",
    "richard",
    "fucker",
    "orange",
    "merlin",
    "michelle",
    "corvette",
    "bigdog",
    "cheese",
    "matthew",
    "121212",
    "patrick",
    "martin",
    "freedom",
    "ginger",
    "blowjob",
    "nicole",
    "sparky",
    "yellow",
    "camaro",
    "secret",
    "dick",
    "falcon",
    "taylor",
    "111111",
    "131313",
    "123123",
    "bitch",
    "hello",
    "scooter",
    "please",
    "porsche",
    "guitar",
    "chelsea",
    "black",
    "diamond",
    "nascar",
    "jackson",
    "cameron",
    "654321",
    "computer",
    "amanda",
    "wizard",
    "xxxxxxxx",
    "money",
    "phoenix",
    "mickey",
    "bailey",
    "knight",
    "iceman",
    "tigers",
    "purple",
    "andrea",
    "horny",
    "dakota",
    "aaaaaa",
    "player",
    "sunshine",
    "morgan",
    "starwars",
    "boomer",
    "cowboys",
    "edward",
    "charles",
    "girls",
    "booboo",
    "coffee",
    "xxxxxx",
    "bulldog",
    "ncc1701",
    "rabbit",
    "peanut",
    "john",
    "johnny",
    "gandalf",
    "spanky",
    "winter",
    "brandy",
    "compaq",
    "carlos",
    "tennis",
    "james",
    "mike",
    "brandon",
    "fender",
    "anthony",
    "blowme",
    "ferrari",
    "cookie",
    "chicken",
    "maverick",
    "chicago",
    "joseph",
    "diablo",
    "sexsex",
    "hardcore",
    "666666",
    "willie",
    "welcome",
    "chris",
    "panther",
    "yamaha",
    "justin",
    "banana",
    "driver",
    "marine",
    "angels",
    "fishing",
    "david",
    "maddog",
    "hooters",
    "wilson",
    "butthead",
    "dennis",
    "fucking",
    "captain",
    "bigdick",
    "chester",
    "smokey",
    "xavier",
    "steven",
    "viking",
    "snoopy",
    "blue",
    "eagles",
    "winner",
    "samantha",
    "house",
    "miller",
    "flower",
    "jack",
    "firebird",
    "butter",
    "united",
    "turtle",
    "steelers",
    "tiffany",
    "zxcvbn",
    "tomcat",
    "golf",
    "bond007",
    "bear",
    "tiger",
    "doctor",
    "gateway",
    "gators",
    "angel",
    "junior",
    "thx1138",
    "porno",
    "badboy",
    "debbie",
    "spider",
    "melissa",
    "booger",
    "1212",
    "flyers",
    "fish",
    "porn",
    "matrix",
    "teens",
    "scooby",
    "jason",
    "walter",
    "cumshot",
    "boston",
    "braves",
    "yankee",
    "lover",
    "barney",
    "victor",
    "tucker",
    "princess",
    "mercedes",
    "5150",
    "doggie",
    "zzzzzz",
    "gunner",
    "horney",
    "bubba",
    "2112",
    "fred",
    "johnson",
    "xxxxx",
    "tits",
    "member",
    "boobs",
    "donald",
    "bigdaddy",
    "bronco",
    "penis",
    "voyager",
    "rangers",
    "birdie",
    "trouble",
    "white",
    "topgun",
    "bigtits",
    "bitches",
    "green",
    "super",
    "qazwsx",
    "magic",
    "lakers",
    "rachel",
    "slayer",
    "scott",
    "2222",
    "asdf",
    "video",
    "london",
    "7777",
    "marlboro",
    "srinivas",
    "internet",
    "action",
    "carter",
    "jasper",
    "monster",
    "teresa",
    "jeremy",
    "11111111",
    "bill",
    "crystal",
    "peter",
    "pussies",
    "cock",
    "beer",
    "rocket",
    "theman",
    "oliver",
    "prince",
    "beach",
    "amateur",
    "7777777",
    "muffin",
    "redsox",
    "star",
    "testing",
    "shannon",
    "murphy",
    "frank",
    "hannah",
    "dave",
    "eagle1",
    "11111",
    "mother",
    "nathan",
    "raiders",
    "steve",
    "forever",
    "angela",
    "viper",
    "ou812",
    "jake",
    "lovers",
    "suckit",
    "gregory",
    "buddy",
    "whatever",
    "young",
    "nicholas",
    "lucky",
    "helpme",
    "jackie",
    "monica",
    "midnight",
    "college",
    "baby",
    "cunt",
    "brian",
    "mark",
    "startrek",
    "sierra",
    "leather",
    "232323",
    "4444",
    "beavis",
    "bigcock",
    "happy",
    "sophie",
    "ladies",
    "naughty",
    "giants",
    "booty",
    "blonde",
    "fucked",
    "golden",
//        "0",
    "fire",
    "sandra",
    "pookie",
    "packers",
    "einstein",
    "dolphins",
//        "0",
    "chevy",
    "winston",
    "warrior",
    "sammy",
    "slut",
    "8675309",
    "zxcvbnm",
    "nipples",
    "power",
    "victoria",
    "asdfgh",
    "vagina",
    "toyota",
    "travis",
    "hotdog",
    "paris",
    "rock",
    "xxxx",
    "extreme",
    "redskins",
    "erotic",
    "dirty",
    "ford",
    "freddy",
    "arsenal",
    "access14",
    "wolf",
    "nipple",
    "iloveyou",
    "alex",
    "florida",
    "eric",
    "legend",
    "movie",
    "success",
    "rosebud",
    "jaguar",
    "great",
    "cool",
    "cooper",
    "1313",
    "scorpio",
    "mountain",
    "madison",
    "987654",
    "brazil",
    "lauren",
    "japan",
    "naked",
    "squirt",
    "stars",
    "apple",
    "alexis",
    "aaaa",
    "bonnie",
    "peaches",
    "jasmine",
    "kevin",
    "matt",
    "qwertyui",
    "danielle",
    "beaver",
    "4321",
    "4128",
    "runner",
    "swimming",
    "dolphin",
    "gordon",
    "casper",
    "stupid",
    "shit",
    "saturn",
    "gemini",
    "apples",
    "august",
    "3333",
    "canada",
    "blazer",
    "cumming",
    "hunting",
    "kitty",
    "rainbow",
    "112233",
    "arthur",
    "cream",
    "calvin",
    "shaved",
    "surfer",
    "samson",
    "kelly",
    "paul",
    "mine",
    "king",
    "racing",
    "5555",
    "eagle",
    "hentai",
    "newyork",
    "little",
    "redwings",
    "smith",
    "sticky",
    "cocacola",
    "animal",
    "broncos",
    "private",
    "skippy",
    "marvin",
    "blondes",
    "enjoy",
    "girl",
    "apollo",
    "parker",
    "qwert",
    "time",
    "sydney",
    "women",
    "voodoo",
    "magnum",
    "juice",
    "abgrtyu",
    "777777",
    "dreams",
    "maxwell",
    "music",
    "rush2112",
    "russia",
    "scorpion",
    "rebecca",
    "tester",
    "mistress",
    "phantom",
    "billy",
    "6666",
    "albert",
  );
}
