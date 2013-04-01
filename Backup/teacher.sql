-- MySQL dump 10.13  Distrib 5.5.28, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: teacher
-- ------------------------------------------------------
-- Server version	5.5.28-0ubuntu0.12.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(20) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `content` varchar(100) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `new_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `new_id` (`new_id`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`new_id`) REFERENCES `news` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (7,'jackieLin','upload/root.jpg','fgfdgdfg','2013-04-01 11:21:07',2);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `competence`
--

DROP TABLE IF EXISTS `competence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competence`
--

LOCK TABLES `competence` WRITE;
/*!40000 ALTER TABLE `competence` DISABLE KEYS */;
INSERT INTO `competence` VALUES (1,'login'),(2,'checkall');
/*!40000 ALTER TABLE `competence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `competence_role`
--

DROP TABLE IF EXISTS `competence_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competence_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `com_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `com_id` (`com_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `competence_role_ibfk_1` FOREIGN KEY (`com_id`) REFERENCES `competence` (`id`),
  CONSTRAINT `competence_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competence_role`
--

LOCK TABLES `competence_role` WRITE;
/*!40000 ALTER TABLE `competence_role` DISABLE KEYS */;
INSERT INTO `competence_role` VALUES (1,1,1),(2,2,2),(3,1,2);
/*!40000 ALTER TABLE `competence_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `educate_body`
--

DROP TABLE IF EXISTS `educate_body`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `educate_body` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content_id` int(11) DEFAULT NULL,
  `hasparent` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `content_id` (`content_id`),
  CONSTRAINT `educate_body_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `educate_body`
--

LOCK TABLES `educate_body` WRITE;
/*!40000 ALTER TABLE `educate_body` DISABLE KEYS */;
INSERT INTO `educate_body` VALUES (1,'5',1,1,0),(2,'5',1,2,0),(3,'5',1,3,0),(4,'5',1,4,0),(5,'教学成果良好,有突出事迹,或受到校级以上表彰',1,1,1),(6,'教学负责,学生和老师普遍反映满意',1,2,1),(7,'没有出现教学事故,教学任务按计划完成',1,3,1),(8,'出现教学时故,或未按计划完成教学任务',1,4,1),(9,'本专业学术专著,全国统编教材的主编,副主编',1,5,1),(10,'参编全国教材,(副)主编省级教材',1,6,1),(11,'实验室改造、搬迁计划或重要设备安装',1,10,1),(12,'当年新建基地的负责人',1,12,1);
/*!40000 ALTER TABLE `educate_body` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `educate_content`
--

DROP TABLE IF EXISTS `educate_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `educate_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(100) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  CONSTRAINT `educate_content_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `educate_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `educate_content`
--

LOCK TABLES `educate_content` WRITE;
/*!40000 ALTER TABLE `educate_content` DISABLE KEYS */;
INSERT INTO `educate_content` VALUES (1,'教学成果良好,有突出事迹,或受到校级以上表彰',5),(2,'教学负责,学生和老师普遍反映满意',5),(3,'没有出现教学事故,教学任务按计划完成',5),(4,'出现教学时故,或未按计划完成教学任务',5),(5,'本专业学术专著,全国统编教材的主编,副主编',6),(6,'参编全国教材,(副)主编省级教材',6),(7,'(副)主编消极教材,参编省级教材,科普书籍',6),(8,'参编消极教材,cai制作',6),(9,'新建实验室',7),(10,'实验室改造、搬迁计划或重要设备安装',7),(11,'负责常规管理和维护',7),(12,'当年新建基地的负责人',8),(13,'基地的日常管理己指导工作及参与新建基地的主要人员',8);
/*!40000 ALTER TABLE `educate_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `educate_type`
--

DROP TABLE IF EXISTS `educate_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `educate_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `showtype` varchar(20) DEFAULT NULL,
  `comment` varchar(20) DEFAULT NULL,
  `competence_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `competence_id` (`competence_id`),
  CONSTRAINT `educate_type_ibfk_1` FOREIGN KEY (`competence_id`) REFERENCES `competence` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `educate_type`
--

LOCK TABLES `educate_type` WRITE;
/*!40000 ALTER TABLE `educate_type` DISABLE KEYS */;
INSERT INTO `educate_type` VALUES (1,'指导本科生学习','text','人数',2),(2,'指导本科生毕业论文','text','数量',2),(3,'指导研究生或博士后','text','人数',2),(4,'研究生论文答辩','text','人数',2),(5,'教学质量','checkbox','教学质量',2),(6,'教学建设','checkbox','教学建设',2),(7,'实验室建设','select','实验室建设',2),(8,'基地建设','checkbox','基地建设',2);
/*!40000 ALTER TABLE `educate_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `links`
--

DROP TABLE IF EXISTS `links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `links`
--

LOCK TABLES `links` WRITE;
/*!40000 ALTER TABLE `links` DISABLE KEYS */;
INSERT INTO `links` VALUES (1,'华南农业大学教务处','http://jwc.scau.edu.cn/index.html'),(2,'华农红满堂','http://hometown.scau.edu.cn/bbs/forum.php'),(3,'HTML5中文网','http://www.html5china.com/'),(4,'php','http://php.net/'),(5,'大猫の意淫筆記','http://ooxx.me/');
/*!40000 ALTER TABLE `links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `navigation`
--

DROP TABLE IF EXISTS `navigation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `navigation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `navigation`
--

LOCK TABLES `navigation` WRITE;
/*!40000 ALTER TABLE `navigation` DISABLE KEYS */;
INSERT INTO `navigation` VALUES (1,'首页','http://teacherw.sinaapp.com/main.html?type=middle_content'),(2,'教学','http://teacherw.sinaapp.com/main.html?type=educate'),(3,'科研','http://teacherw.sinaapp.com/main.html?type=teach'),(4,'技术推广','http://teacherw.sinaapp.com/main.html?type=teachnology'),(5,'数据生成','http://teacherw.sinaapp.com/main.html?type=generation');
/*!40000 ALTER TABLE `navigation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(20) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(100) NOT NULL,
  `content` mediumtext,
  `commNum` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'jackieLin','2013-04-01 08:33:27','我校离退休工作处被省老干部局评为统计工作全优单位','<p style=\"text-align:justify\"><span style=\"line-height:175%;font-size:16px\">   日前，中共广东省委老干部局以粤老通〔2013〕10号发出《关于2012年离退休干部统计年报表评审结果的通报》，我校离退休工作处被评为统计工作“全优单位”。据悉，此次全省共评出“全优单位”135个，“优秀单位”24个。</span></p><p style=\"text-align:justify\"><span style=\"line-height:175%;font-size:16px\">　　离退休干部统计是老干部工作的重要内容，是开展老干部工作的重要参考。近年来，我校对离退休干部统计年报表工作非常重视，认真按照报表统计要求，严格审核数据，对信息有变化的及时进行调整修改，确保了信息的准确性与真实性，保证了统计工作的质量和水平。 (文/离退休工作处)</span></p>',0),(2,'jackieLin','2013-04-01 11:21:07','我校志愿者圆满完成2013年乒乓球团体世界杯赛志愿服务','<p><span style=\"line-height:175%;font-size:16px\">           3月31日，由国际乒联授权，中国乒协、广州市体育局主办，广州市乒乓球协会承办的2013年乒乓球团体世界杯赛在广州天河体育馆落下帷幕。由我校136名来自不同学院和专业的学生组成的志愿者队伍，圆满完成了从23日到31日为期9天的赛事筹备及运行等方面的志愿服务工作。</span></p><p><span style=\"line-height:175%;font-size:16px\">     　　在此次服务活动中，我校志愿者主要负责酒店与机场接待、物资配送、观众组织、宣传外联、安保、接待、制证、行政文秘、赞助商服务等多项工作，虽然服务内容多、服务时间长、时不时还会遇上恶劣天气，但志愿者一直坚守在岗位上。安保工作的部分志愿者，是负责露天停车场的指引工作的，而从28号到31号，几乎是天天下雨，这给指引工作造成了很大不便，但负责这部分工作的志愿者，仍然是撑着伞，在大雨中为观众和嘉宾提供服务。</span></p><p><span style=\"line-height:175%;font-size:16px\">     　　虽然是早上7点多出发，晚上11点多才回到宿舍，但不少志愿者都表示这样的工作很有意义。一位12级的第一次当志愿者的同学说：“我们助班师姐是做过2010年广州亚运会志愿者的，她一直鼓励我们要多参加一些志愿服务活动，我的第一次志愿者经历，就是这么大型的体育赛事，相当满足了。我从一开始的很不习惯，到现在的工作顺手，我觉得自己学到了很多东西，蛮有意义的。”一名10级的安保部的志愿者则表示在早出晚归的忙碌中，收获了一份难得的友情，这应该是他学生时代最后一次志愿者经历了，所以觉得特别珍惜、特别有意义，帮助别人也给自己留下了一份永恒的回忆。（文/校报学生记者郑宗敬）</span></p><p>    <strong>相关链接：</strong></p><p>    　　乒乓球团体世界杯赛事是国际乒乓球联合会主办的世界顶级乒乓球赛事，是与奥运会、世界乒乓球锦标赛同为世界乒乓球三大赛事之一，分为男团与女团。今年的这一届比赛由来自24个国家和地区的世界排名前12的男女团体约200多名运动员、教练员参赛，赛事水平和观赏性都非常高。</p>',1),(3,'jackieLin','2013-04-01 09:07:24','经管学院荣获“全国大学生条码自动识别知识竞赛示范院校”','<p style=\"text-align:center\"><img src=\"main/image?path=newsimage/W020130401352370090254.jpg\" /></p><p><span style=\"line-height:175%;font-size:16px\">          3月29日下午，经济管理学院在院楼601报告厅举行高校条码知识普及暨物联网与食品安全可追溯学术报告会，会上，我校经济管理学院获颁“2013全国大学生条码自动识别知识竞赛示范院校”荣誉称号。</span></p><p><span style=\"line-height:175%;font-size:16px\">     经济管理学院副院长罗明忠和广州市标准化研究院副院长梁小明分别上台致辞，宣布2013年全国大学生条码自动识别知识竞赛高校巡讲（华农站）正式启动。全国大学生条码自动识别知识竞赛组委会秘书长张铎向我校经济管理学院授予“2013全国大学生条码自动识别知识竞赛示范院校”牌匾，经济管理学院党委副书记张晖代表学院领奖。</span></p><p><span style=\"line-height:175%;font-size:16px\">     报告会上，21世纪中国电子商务网校校长、全国大学生条码自动识别知识竞赛组委会秘书长张铎教授以《物联网走向我们》为题，围绕自动识别技术，以生动有趣的例子阐述了物联网发展的新趋势；中国物品编码中心技术部副主任王毅作《条码技术应用与物联网》的学术报告，讲解了条码技术的应用以及物联网与食品安全可追溯的原理；《现代物流报》广东部副主任张晶林指出了人才培养与企业需求的方向，认为大学生在校期间要有四项准备、三项技能：知识准备、心理准备、技能准备和能力准备，以及演讲能力、礼仪交往能力和应急处理能力，在学习过程中要多汲取课外知识，掌握一手技能，提高沟通、协调和写作能力，全方位发展自我。</span></p><p><span style=\"line-height:175%;font-size:16px\">     21世纪中国电子商务网校教师田金禄、中国物品编码中心技术部副主任王毅、广州市标准化研究院（中国物品编码中心广州分中心）副院长梁小明、《现代物流报》广东部副主任张晶林、现代物流报广东办事处主任黄军、经济管理学院党委副书记张晖、副院长罗明忠、营销系主任张光辉出席了本次报告会。会议由经济管理学院副院长文晓巍、物流管理专业主任王雄志主持。</span></p><p><span style=\"line-height:175%;font-size:16px\">     据悉，中国物品编码中心自2007年开始举办“全国大学生条码自动识别知识竞赛”，已成功举办了6届竞赛，累计参赛高校近920校次，参赛学生34000人，竞赛得到了全国开设相关课程高校的热烈响应。“2013全国大学生条码自动识别知识竞赛”已于2013年2月26日正式开始，同期举办“条码知识普及与物联网食品安全追溯”巡讲活动。（文/图 经济管理学院）</span></p>',0),(4,'jackieLin','2013-04-01 09:20:22','第六届读书节系列活动拉开序幕 带领读者探索电影中的古典音乐','<p style=\"text-align:center\"><img src=\"main/image?path=newsimage/W020130401332638375384.jpg\" /></p><p><span style=\"line-height:175%;font-size:16px\">      3月29日下午，图书馆报告厅举办了第六届读书节系列活动之“影·乐——电影中的古典音乐”的讲座活动，讲座由KUKE数字音乐图书馆音乐编辑韩波主讲。讲座吸引了众多的同学前来听讲。</span></p><p><span style=\"line-height:175%;font-size:16px\">      在一部电影的制作过程中，电影音频后期制作占据着很重要的地位。那么在当代的电影中，电影的叙事和古典音乐的抒情在银幕上是通过怎样的结合，让电影更动人，音乐更美妙，内涵更丰富呢？</span></p><p style=\"text-align:center\"><img src=\"main/image?path=newsimage/W020130401332638374042.jpg\" /></p><p><span style=\"line-height:175%;font-size:16px\">    　　讲座中，韩老师通过几部经典电影的片段向观众剖析了各影片中的古典音乐的独特之处，以其专业的理解和独特的视角将现场观众带入了一个古典音乐的世界。《憨豆先生的假日》中憨豆先生街头卖艺的片段中用了4段音乐，唯有最后一段古典音乐普契尼的《贾尼·斯基基》与憨豆先生的表演完美契合，博得了群众的认可。电影《黑天鹅》中，导演则运用了大量柴可夫斯基的音乐，既融合了芭蕾舞《天鹅湖》的主线，又将柴可夫斯基的个人命运与女主角的命运联系起来，变化起伏的古典音乐契合着电影中黑与白的较量。在《香奈儿秘密情史》中，导演用了斯特拉文斯基的《春之祭》，将音乐的创新与电影中香奈儿引领了时尚风尚完美的人物性格完美展现出来。</span></p><p><span style=\"line-height:175%;font-size:16px\">    　　韩老师指出，电影中美妙和谐的古典音乐有些在创作时是“反其道而行”，打破常规，使得音乐在影中被运用得更适当。《钢琴家》搭上肖邦的《G小调第一叙事曲》，在和谐之中，正义与邪恶表现得更加淋漓尽致。</span></p><p style=\"text-align:center\"><img src=\"main/image?path=newsimage/W020130401332638376778.jpg\" /></p><p><span style=\"line-height:175%;font-size:16px\">    　　为了让大家对讲座的内容理解得更深刻透彻，韩老师进行随堂互动，给了个“听乐配画面”的情景模拟，让大家学以致用，自由发挥想象。听着贝多芬的《第七交响曲》，现场同学迸发导演思维的火花，认真构思情节画面，随后踊跃地与老师互动，交流想法。而《第七交响曲》运用于经典电影《国王的演讲》中，将缺陷与美好两种对比鲜明地从音乐中展现出来。</span></p><p><span style=\"line-height:175%;font-size:16px\">    　　听完讲座后，来自艺术学院广播电视编导专业的周同学说道：“这场讲座对于拓展我的专业知识有很大的帮助，听后受益匪浅。”“虽然我不是业内人士，但我还是喜欢研究一些电影的制作技法，这是我个人兴趣所在，”来自人文与法学学院中文系专业的林同学也表示，“听韩老师讲完后，顿然感觉在探索的路途上向前迈进一步。”（文/校报学生记者 邓淑燕 陈晓晴 林晓棠 图/图书馆）</span></p>',0);
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'login'),(2,'teacher');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `role_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  CONSTRAINT `role_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (1,1,1),(2,2,1);
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teach_body`
--

DROP TABLE IF EXISTS `teach_body`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teach_body` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `condition` int(11) DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL,
  `hassubparent` tinyint(4) DEFAULT NULL,
  `content_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`user_id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teach_body`
--

LOCK TABLES `teach_body` WRITE;
/*!40000 ALTER TABLE `teach_body` DISABLE KEYS */;
INSERT INTO `teach_body` VALUES (9,'gbgbg',34,'2013',1,1,1);
/*!40000 ALTER TABLE `teach_body` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teach_content`
--

DROP TABLE IF EXISTS `teach_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teach_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `haschildren` tinyint(4) DEFAULT NULL,
  `competence_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `competence_id` (`competence_id`),
  KEY `type_id` (`type_id`),
  CONSTRAINT `teach_content_ibfk_1` FOREIGN KEY (`competence_id`) REFERENCES `competence` (`id`),
  CONSTRAINT `teach_content_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `teach_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teach_content`
--

LOCK TABLES `teach_content` WRITE;
/*!40000 ALTER TABLE `teach_content` DISABLE KEYS */;
INSERT INTO `teach_content` VALUES (1,'主持国际、国家级重点课题',1,2,1),(2,'主持国家级一般课程',0,2,1),(3,'主持省部级重点课题',0,2,1),(4,'主持的横向课题当年到位经费在20万元以上（文科十万元以上）',0,2,1),(5,'主持省部级课题当年到位经费在15万元以上（文科八万元以上）',0,2,1),(6,'主持省部级横向课题当年到位经费在15万元以上（文科八万元以上）',0,2,1),(7,'主持厅局级课题当年到位经费在10万元以上（文科五万元以上）',0,2,1),(8,'主持厅级横向课程当年到位经费在10万元以上（文科5万元以上）',0,2,1),(9,'校级及参加其他一般课题',0,2,1),(10,'在Natrue,science或影响因子在10.0以上刊物发表文章一篇（第四名起算）',0,2,2),(11,'在科学通报、中国科学、求是、中国社会科学等发表文章（第二名起算）',0,2,2),(12,'国外四大索引收录刊物发表文章',0,2,2),(13,'国内一级刊物发表论文',0,2,2),(14,'国外重要学术刊物发表论文',0,2,2),(15,'国内二级刊物发表论文',0,2,2),(16,'国外一般学术刊物发表论文',0,2,2),(17,'其他及一般学术刊物上发表论文',0,2,2),(18,'获国际、国家级奖励',0,2,3),(19,'获省级二等奖',0,2,3),(20,'省级三等奖',0,2,3),(21,'获省级科技奖励',0,2,3),(22,'获省级专利',0,2,3),(23,'获省级以上品种审定',0,2,3),(24,'获厅局级科技奖励',0,2,3),(25,'获校级和其他成果奖励者',0,2,3);
/*!40000 ALTER TABLE `teach_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teach_subcontent`
--

DROP TABLE IF EXISTS `teach_subcontent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teach_subcontent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `competence_id` int(11) DEFAULT NULL,
  `content_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `competence_id` (`competence_id`),
  KEY `content_id` (`content_id`),
  CONSTRAINT `teach_subcontent_ibfk_1` FOREIGN KEY (`competence_id`) REFERENCES `competence` (`id`),
  CONSTRAINT `teach_subcontent_ibfk_2` FOREIGN KEY (`content_id`) REFERENCES `teach_content` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teach_subcontent`
--

LOCK TABLES `teach_subcontent` WRITE;
/*!40000 ALTER TABLE `teach_subcontent` DISABLE KEYS */;
INSERT INTO `teach_subcontent` VALUES (1,'150万元以上',2,1),(2,'100万元以上',2,1),(3,'80万元以上',2,1),(4,'50万元以上',2,1),(5,'50万元以下（不含50万元）',2,1);
/*!40000 ALTER TABLE `teach_subcontent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teach_type`
--

DROP TABLE IF EXISTS `teach_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teach_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `competence_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `competence_id` (`competence_id`),
  CONSTRAINT `teach_type_ibfk_1` FOREIGN KEY (`competence_id`) REFERENCES `competence` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teach_type`
--

LOCK TABLES `teach_type` WRITE;
/*!40000 ALTER TABLE `teach_type` DISABLE KEYS */;
INSERT INTO `teach_type` VALUES (1,'科研项目类型',2),(2,'科研论文类型',2),(3,'科研成果类型',2);
/*!40000 ALTER TABLE `teach_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachno_body`
--

DROP TABLE IF EXISTS `teachno_body`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teachno_body` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `condition` int(11) DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL,
  `content_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `content_id_idx` (`content_id`),
  KEY `user_id_idx` (`user_id`),
  CONSTRAINT `f_content_id` FOREIGN KEY (`content_id`) REFERENCES `teachno_content` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `f_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachno_body`
--

LOCK TABLES `teachno_body` WRITE;
/*!40000 ALTER TABLE `teachno_body` DISABLE KEYS */;
/*!40000 ALTER TABLE `teachno_body` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachno_content`
--

DROP TABLE IF EXISTS `teachno_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teachno_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  CONSTRAINT `teachno_content_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `teachno_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachno_content`
--

LOCK TABLES `teachno_content` WRITE;
/*!40000 ALTER TABLE `teachno_content` DISABLE KEYS */;
INSERT INTO `teachno_content` VALUES (1,'有纵向资助的重要推广项目，当年到位经费50万元以上',1),(2,'有纵向资助的重要推广项目，当年到位经费30万元以上',1),(3,'有纵向资助的一般推广项目或有重要的横向资助的推广项目，到位经费10万元以上',1),(4,'有立项的推广项目，到位经费在5万元以上',1),(5,'其他有立项的推广项目及参加者',1),(6,'有立项的推广项目，当年产生的社会经济效益在200万元以上，或为学校提供的收益达70万元以上',2),(7,'有立项的推广项目，当年产生的社会经济效益在1000万元以上，或为学校提供的收益达50万元以上',2),(8,'有立项的推广项目，当年产生的社会经济效益在500万元以上，或为学校提供的收益在20万元以上',2),(9,'有立项推广项目，当年为学校提供的收益在10万元以上',2),(10,'有立项推广项目，当年为学校提供的收益在5万元以上',2),(11,'有立项推广项目，当年产生的效益明显，当年为学校提供的收益5万元以下',2),(12,'到基层单位推广的工作日以学院统一登记，年终累加为准（天数）',3);
/*!40000 ALTER TABLE `teachno_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachno_type`
--

DROP TABLE IF EXISTS `teachno_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teachno_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `competence_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `competence_id` (`competence_id`),
  CONSTRAINT `teachno_type_ibfk_1` FOREIGN KEY (`competence_id`) REFERENCES `competence` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachno_type`
--

LOCK TABLES `teachno_type` WRITE;
/*!40000 ALTER TABLE `teachno_type` DISABLE KEYS */;
INSERT INTO `teachno_type` VALUES (1,'推广项目类型',2),(2,'推广成果',2),(3,'推广工作量',2);
/*!40000 ALTER TABLE `teachno_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `number` varchar(15) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `avater` varchar(100) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT '0',
  `birthday` varchar(20) DEFAULT NULL,
  `living` varchar(100) DEFAULT NULL,
  `bornplace` varchar(100) DEFAULT NULL,
  `college` varchar(20) DEFAULT NULL,
  `post` varchar(20) DEFAULT NULL,
  `specialty` varchar(50) DEFAULT NULL,
  `tutorial` varchar(50) DEFAULT NULL,
  `office` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'jackieLin','林滨','1','c4ca4238a0b923820dcc509a6f75849b','upload/jackieLin.jpg',0,'2013-04-03','广东省揭阳市揭东县','广东省揭阳市揭东县','信息学院','教师','计算机科学与技术','数据库理论','华山24-611','15989192028','dashi_lin@163.com');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-04-01 23:34:08
