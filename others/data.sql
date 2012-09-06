INSERT INTO station VALUES (1,'Uherskohradistska nemocnice',68601,'Uherske Hradiste','U Nemocnice 123');
INSERT INTO station VALUES (2,'Soukroma Transfuzni stanice UH',68603,'Uherske Hradiste','U Moravy 18');
INSERT INTO station VALUES (3,'Statni transfuzni stanice',16000,'Praha 2','Kollarova 823');
INSERT INTO station VALUES (4,'Mestska transfuzni stanice',76001,'Zlin','Batova 2');

INSERT INTO nurse VALUES (1,'npavel00','6bc512d3e25169acf30fa31de9a6298c','Jan','Pavel',101,001,68703,'Babice','Drazni 8',6507674039,'+420787123456');
INSERT INTO nurse VALUES (2,'nnovaa00','6bc512d3e25169acf30fa31de9a6298c','Jana','Nova',101,002,68603,'Stare Mesto','U Cukrovaru 39',7615363909,'+420541235565');
INSERT INTO nurse VALUES (3,'nnovak00','6bc512d3e25169acf30fa31de9a6298c','Pavel','Novak',101,003,17007,'Praha 20','Stromoradi 8',6511784789,'+420678754672');
INSERT INTO nurse VALUES (4,'nsomra00','6bc512d3e25169acf30fa31de9a6298c','Karel','Somrak',101,004,76345,'Brezuvky','Hlavni 3',6729371039,'+420637283946');
INSERT INTO nurse VALUES (5,'nsmrnc00','6bc512d3e25169acf30fa31de9a6298c','Libuse','Smrnc',100,001,68602,'Uherske Hradiste','U Kotelny 100',8257291038,'+420567293098');
INSERT INTO nurse VALUES (6,'nvasku00','6bc512d3e25169acf30fa31de9a6298c','Julie','Vasku',090,004,76003,'Zlin','Bartosova 1024',8958291039,NULL);
INSERT INTO nurse VALUES (7,'ncisto00','6bc512d3e25169acf30fa31de9a6298c','Alena','Cistotna',026,002,68601,'Uherske Hradiste','U Nemocnice 205',6060682636,NULL);

INSERT INTO donor VALUES (1,'skrom00','6bc512d3e25169acf30fa31de9a6298c','Radek','Skromny',68606,'Uherske Hradiste','Hlavni 30',NULL,NULL,'0-',7876543216,1,001,NULL);
INSERT INTO donor VALUES (2,'zelen00','6bc512d3e25169acf30fa31de9a6298c','Johana','Zelena',68603,'Stare Mesto','Vedlejsi 2','+420678493843',NULL,'AB+',8862565263,0,001,'Nevolnost, kolabuje, doporuceno odhlaseni');
INSERT INTO donor VALUES (3,'novaa00','6bc512d3e25169acf30fa31de9a6298c','Klara','Nova',68602,'Kunovice','U Cihelny 32',NULL,'klaranova@mailsever.mail','A+',9061977656,1,001,NULL);
INSERT INTO donor VALUES (4,'cihla00','6bc512d3e25169acf30fa31de9a6298c','Vincent','Cihlar',68601,'Uherske Hradiste','Protzkarova 15',NULL,'vcihlar@mailsever.mail','0+',7503214784,1,004,NULL);
INSERT INTO donor VALUES (5,'zablo00','6bc512d3e25169acf30fa31de9a6298c','Mia','Zabloudilova',68602,'Praha','Videnska 154','+420789456123','miazab@mailsever.mail','A+',8252057892,1,003,NULL);

INSERT INTO drawn VALUES (1,'2011-02-25 06:52:02',0000001,'0-',00005,001,NULL,1);
INSERT INTO drawn VALUES (2,'2011-04-02 08:02:45',0000002,'AB+',00001,001,NULL,1);
INSERT INTO drawn VALUES (3,'2012-01-17 13:05:41',0000003,'A+',00005,001,NULL,1);
INSERT INTO drawn VALUES (4,'2011-05-19 10:14:08',0000002,'AB+',00003,003,NULL,1);
INSERT INTO drawn VALUES (6,'2010-11-08 11:31:25',0000001,'0-',00007,001,NULL,1);
INSERT INTO drawn VALUES (7,'2011-01-11 07:56:35',0000005,'A+',00003,003,NULL,1);
INSERT INTO drawn VALUES (8,'2012-03-15 09:11:22',0000004,'0+',00006,004,NULL,1);
INSERT INTO drawn VALUES (9,'2011-11-13 09:34:15',0000005,'A+',00002,002,NULL,1);

INSERT INTO reservation VALUES (1,'Motol Praha','B+',8,'2012-03-30 07:00:00',NULL,'odbavena');
INSERT INTO reservation VALUES (2,'Uherskohradistska Nemocnice','0-',7,'2012-03-30 07:00:00',NULL,'v prubehu');

INSERT INTO invitation VALUES (1,0000001,'2012-04-01 07:00:00',001,'normal');
INSERT INTO invitation VALUES (2,0000003,'2012-03-30 07:00:00',001,'normal');
