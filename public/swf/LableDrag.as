package {
	/* 	Developer: Joseph Orlando
		Name: LableDrag 
		Code: AS3
		
		Description: Drag and drop the lable into position for a  
	*/
	import flash.display.Sprite;
	import flash.display.MovieClip;
	import flash.display.DisplayObject;
	import flash.events.Event;
	import flash.events.MouseEvent;
	import flash.display.StageAlign;
	import flash.display.StageScaleMode;
	import flash.text.TextFormat;
	import flash.filters.*;
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	import flash.printing.PrintJob; 
	import flash.geom.Rectangle;
	import flash.errors.*;
	import flash.sampler.NewObjectSample;

	[SWF(width=612, height=792)];
	public class LableDrag extends Sprite {
		private var column1:Number;
		private var column2:Number;
		private var column3:Number;
		private var row1:Number;
		private var row2:Number;
		private var row3:Number;
		private var row4:Number;
		private var row5:Number;
		private var row6:Number;
		private var row7:Number;
		private var myGlow:GlowFilter=new GlowFilter(0x5cAA00,0.7,17,17,5,3);
		private var myGlowOff:GlowFilter = new GlowFilter(0xFFFFFF, 0.0, 5, 5);	
		private var newTarget:MovieClip;
		private var loaderXML:URLLoader = new URLLoader();
		private var xml:XML;
		public function LableDrag() {
			loaderXML.load(new URLRequest("../xml/label.xml"));
			loaderXML.addEventListener(Event.COMPLETE, onLoaded);
 		}
		private function onLoaded(e:Event){
			xml=new XML(e.target.data);
			var list:XMLList=xml.labels;
			mcLable1.mcText.names.text = mcLable2.mcText.names.text = 
			mcLable3.mcText.names.text = mcLable4.mcText.names.text = list.name;
			
			mcLable1.mcText.dob.text = mcLable2.mcText.dob.text = 
			mcLable3.mcText.dob.text = mcLable4.mcText.dob.text = list.dob;
			
			mcLable1.mcText.lot.text = mcLable2.mcText.lot.text = 
			mcLable3.mcText.lot.text = mcLable4.mcText.lot.text = list.lot;
			
			mcLable1.mcText.ingredients.text = mcLable2.mcText.ingredients.text = 
			mcLable3.mcText.ingredients.text = mcLable4.mcText.ingredients.text = list.ingredients;
			
			mcLable1.mcText.exp.text = mcLable2.mcText.exp.text = 
			mcLable3.mcText.exp.text = mcLable4.mcText.exp.text = 'EXP '+ list.exp;
			
			var numVials:int = list.numVials;
			var textFormat1:TextFormat = new TextFormat;
			textFormat1.size = 8;
			textFormat1.font =  "Arial";
			textFormat1.bold = false;
			mcLable1.mcText.names.rotationZ = -90;
			mcLable2.mcText.names.rotationZ = -90;
			mcLable3.mcText.names.rotationZ = -90;
			mcLable4.mcText.names.rotationZ = -90;

			mcLable1.mcText.dob.rotationZ = -90;
			mcLable2.mcText.dob.rotationZ = -90;
			mcLable3.mcText.dob.rotationZ = -90;
			mcLable4.mcText.dob.rotationZ = -90;

			mcLable1.mcText.lot.rotationZ = -90;
			mcLable2.mcText.lot.rotationZ = -90;
			mcLable3.mcText.lot.rotationZ = -90;
			mcLable4.mcText.lot.rotationZ = -90;
			if ((list.treatment == 0 || list.treatment == 1)){
				var colorArray:Array = new Array();
				if (list.refill == 0){
					colorArray[0] = 0xFFcc00;
					colorArray[1] = 0x009900;
					colorArray[2] = 0xFF0000;
					colorArray[3] = 0x000000;
				}else{
					colorArray[0] = 0x000000;
					colorArray[1] = 0x000000;
					colorArray[2] = 0x000000;
					colorArray[3] = 0x000000;				
				}

				
				textFormat1.color = colorArray[0];
				mcLable1.mcText.names.text =  (mcLable1.mcText.names.text).toUpperCase();
				mcLable1.mcText.names.setTextFormat(textFormat1);
				mcLable1.mcText.dob.setTextFormat(textFormat1);
				mcLable1.mcText.lot.setTextFormat(textFormat1);
				mcLable1.mcText.exp.setTextFormat(textFormat1);
				
				
				textFormat1.color = colorArray[1];
				mcLable2.mcText.names.text =  (mcLable2.mcText.names.text).toUpperCase();
				mcLable2.mcText.names.setTextFormat(textFormat1);
				mcLable2.mcText.dob.setTextFormat(textFormat1);
 				mcLable2.mcText.lot.setTextFormat(textFormat1);
				mcLable2.mcText.exp.setTextFormat(textFormat1);
				
				textFormat1.color = colorArray[2];
				mcLable3.mcText.names.text =  (mcLable3.mcText.names.text).toUpperCase();
				mcLable3.mcText.names.setTextFormat(textFormat1);
 				mcLable3.mcText.dob.setTextFormat(textFormat1);
				mcLable3.mcText.lot.setTextFormat(textFormat1);
				mcLable3.mcText.exp.setTextFormat(textFormat1);		
				
				textFormat1.color = colorArray[3];
				mcLable4.mcText.names.text =  (mcLable4.mcText.names.text).toUpperCase();
				mcLable4.mcText.names.setTextFormat(textFormat1);
				mcLable4.mcText.names.setTextFormat(textFormat1);				
				mcLable4.mcText.dob.setTextFormat(textFormat1);
 				mcLable4.mcText.lot.setTextFormat(textFormat1);
				mcLable4.mcText.exp.setTextFormat(textFormat1);
				
				textFormat1.color = colorArray[0]; 
				textFormat1.size = 5;
				textFormat1.bold = false;
				textFormat1.font =  "Arial";
				mcLable1.mcText.ingredients.setTextFormat(textFormat1);

				
				textFormat1.color = colorArray[1];
				mcLable2.mcText.ingredients.setTextFormat(textFormat1);

				
				textFormat1.color = colorArray[2];
				mcLable3.mcText.ingredients.setTextFormat(textFormat1);

				
				textFormat1.color = colorArray[3];
				mcLable4.mcText.ingredients.setTextFormat(textFormat1);


				}
			else{
				mcLable4.visible = false;
				textFormat1.color = 0x000000;
				mcLable1.mcText.gotoAndStop(2);
				mcLable2.mcText.gotoAndStop(2);
				mcLable3.mcText.gotoAndStop(2);
				
				mcLable1.mcText.names.text =  (mcLable1.mcText.names.text).toUpperCase();
				mcLable1.mcText.names.setTextFormat(textFormat1);
				mcLable2.mcText.names.text =  (mcLable2.mcText.names.text).toUpperCase();
				mcLable2.mcText.names.setTextFormat(textFormat1);
				mcLable3.mcText.names.text =  (mcLable3.mcText.names.text).toUpperCase();
				mcLable3.mcText.names.setTextFormat(textFormat1);
				
				
				mcLable1.mcText.dob.setTextFormat(textFormat1);
 				mcLable1.mcText.lot.setTextFormat(textFormat1);
				mcLable1.mcText.exp.setTextFormat(textFormat1);
				
				mcLable2.mcText.dob.setTextFormat(textFormat1);
 				mcLable2.mcText.lot.setTextFormat(textFormat1);		
				mcLable2.mcText.exp.setTextFormat(textFormat1);
				
				mcLable3.mcText.dob.setTextFormat(textFormat1);
 				mcLable3.mcText.lot.setTextFormat(textFormat1);
				mcLable3.mcText.exp.setTextFormat(textFormat1);
	
				textFormat1.size = 5;
				mcLable1.mcText.ingredients.setTextFormat(textFormat1);
				mcLable2.mcText.ingredients.setTextFormat(textFormat1);
				mcLable3.mcText.ingredients.setTextFormat(textFormat1);
				mcLable1.mcText.dilutionLvl.setTextFormat(textFormat1);
				mcLable2.mcText.dilutionLvl.setTextFormat(textFormat1);
				mcLable3.mcText.dilutionLvl.setTextFormat(textFormat1);
 				mcLable1.mcText.dilutionLvl.text = mcLable2.mcText.dilutionLvl.text = mcLable3.mcText.dilutionLvl.text  =  list.dilutionLevel;

				mcLable1.mcText.ingredients.text = list.vialA; 
				mcLable2.mcText.ingredients.text = list.vialB;
				mcLable3.mcText.ingredients.text = list.vialC;
				
 				if (numVials == 2){
					mcLable3.visible = false;
				} else if (numVials == 1){
					mcLable2.visible = false;
					mcLable3.visible = false;
				}
				
			}
			init();
		}
		private function init():void {
			newTarget = mcHotSpot1;
			column1 =  101.875;
			column2 =  mcHotSpot2.x + 101.875;
			column3 =  mcHotSpot3.x + 101.875;
			mcHotSpot1.taken = true;
			mcHotSpot2.taken = true;
			mcHotSpot3.taken = true;
			mcHotSpot4.taken = true;
			var mc:MovieClip;
			for (var i:int=5; i<=21; i++){
				var mcName:String = "mcHotSpot"+i;
				mc = getChildByName(mcName) as MovieClip;
				mc.taken = false;
			}				
			row1 =  54;
			row2 =  mcHotSpot4.y + 54;
			row3 =  mcHotSpot7.y + 54;
			row4 =  mcHotSpot10.y + 54;
			row5 =  mcHotSpot13.y + 54;
			row6 =  mcHotSpot16.y + 54;
			row7 =  mcHotSpot19.y + 54;
			mcLable1.mouseEnabled = true;
			mcLable2.mouseEnabled = true;
			mcLable3.mouseEnabled = true;
			mcLable4.mouseEnabled = true;
			mcLable1.addEventListener(MouseEvent.MOUSE_DOWN, onMouseDown);
			mcLable1.addEventListener(MouseEvent.MOUSE_UP, onMouseUp);
			mcLable2.addEventListener(MouseEvent.MOUSE_DOWN, onMouseDown);
			mcLable2.addEventListener(MouseEvent.MOUSE_UP, onMouseUp);
			mcLable3.addEventListener(MouseEvent.MOUSE_DOWN, onMouseDown);
			mcLable3.addEventListener(MouseEvent.MOUSE_UP, onMouseUp);
			mcLable4.addEventListener(MouseEvent.MOUSE_DOWN, onMouseDown);
			mcLable4.addEventListener(MouseEvent.MOUSE_UP, onMouseUp);
			mcPrtBtn.addEventListener(MouseEvent.MOUSE_DOWN, printJob);
			mcPrtBtn.mouseEnabled = true;
		}
		private function onMouseDown(event:MouseEvent):void {
			var mc:MovieClip;
			for (var i:int=1; i<=21; i++){
				var mcName:String = "mcHotSpot"+i;
				mc = getChildByName(mcName) as MovieClip;
				mc.mcInner.gotoAndStop(2);
			}
			mcGlow.filters=[myGlow];
			event.currentTarget.addEventListener(Event.ENTER_FRAME,checkHotSpot);
			event.currentTarget.startDrag();
		}
		private function checkHotSpot(event:Event):void {
		  var xPos:Number = event.currentTarget.x;
		  var yPos:Number = event.currentTarget.y;
		  if (xPos <= column1){
			switch (true){
				case (yPos <= row1):
				  newTarget = mcHotSpot1;
				  mcGlow.x = mcHotSpot1.x;
				  mcGlow.y = mcHotSpot1.y;
				break;
				case (yPos > row1 && yPos <= row2) :
				  newTarget = mcHotSpot4;
				  mcGlow.x = mcHotSpot4.x;
				  mcGlow.y = mcHotSpot4.y;
				  break;
				case (yPos > row2 && yPos <= row3) :
				  newTarget = mcHotSpot7;
				  mcGlow.x = mcHotSpot7.x;
				  mcGlow.y = mcHotSpot7.y;
				  break;
				case (yPos > row3 && yPos <= row4) :
				  newTarget = mcHotSpot10;
				  mcGlow.x = mcHotSpot10.x;
				  mcGlow.y = mcHotSpot10.y;
				break;
				case (yPos > row4 && yPos <= row5) :
				  newTarget = mcHotSpot13;
				  mcGlow.x = mcHotSpot13.x;
				  mcGlow.y = mcHotSpot13.y;
				  break;
				case (yPos > row5 && yPos <= row6) :
				  newTarget = mcHotSpot16;
				  mcGlow.x = mcHotSpot16.x;
				  mcGlow.y = mcHotSpot16.y;
				  break;
				default:
				  newTarget = mcHotSpot19;
				  mcGlow.x = mcHotSpot19.x;
				  mcGlow.y = mcHotSpot19.y;
				  break;			
			 }
		  }else if(xPos > column1 && xPos <= column2){
			switch (true){
				case (yPos <= row1):
				  newTarget = mcHotSpot2;
				  mcGlow.x = mcHotSpot2.x;
				  mcGlow.y = mcHotSpot2.y;
				break;
				case (yPos > row1 && yPos <= row2) :
				  newTarget = mcHotSpot5;
				  mcGlow.x = mcHotSpot5.x;
				  mcGlow.y = mcHotSpot5.y;
				  break;
				case (yPos > row2 && yPos <= row3) :
				  newTarget = mcHotSpot8;
				  mcGlow.x = mcHotSpot8.x;
				  mcGlow.y = mcHotSpot8.y;
				  break;
				case (yPos > row3 && yPos <= row4) :
				  newTarget = mcHotSpot11;
				  mcGlow.x = mcHotSpot11.x;
				  mcGlow.y = mcHotSpot11.y;
				break;
				case (yPos > row4 && yPos <= row5) :
				  newTarget = mcHotSpot14;
				  mcGlow.x = mcHotSpot14.x;
				  mcGlow.y = mcHotSpot14.y;
				  break;
				case (yPos > row5 && yPos <= row6) :
				  newTarget = mcHotSpot17;
				  mcGlow.x = mcHotSpot17.x;
				  mcGlow.y = mcHotSpot17.y;
				  break;
				default:
				  newTarget = mcHotSpot20;
				  mcGlow.x = mcHotSpot20.x;
				  mcGlow.y = mcHotSpot20.y;
				  break;			
			 	}
			 }else{
			switch (true){
				case (yPos <= row1):
				  newTarget = mcHotSpot3;
				  mcGlow.x = mcHotSpot3.x;
				  mcGlow.y = mcHotSpot3.y;
				break;
				case (yPos > row1 && yPos <= row2) :
				  newTarget = mcHotSpot6;
				  mcGlow.x = mcHotSpot6.x;
				  mcGlow.y = mcHotSpot6.y;
				  break;
				case (yPos > row2 && yPos <= row3) :
				  newTarget = mcHotSpot9;
				  mcGlow.x = mcHotSpot9.x;
				  mcGlow.y = mcHotSpot9.y;
				  break;
				case (yPos > row3 && yPos <= row4) :
				  newTarget = mcHotSpot12;
				  mcGlow.x = mcHotSpot12.x;
				  mcGlow.y = mcHotSpot12.y;
				break;
				case (yPos > row4 && yPos <= row5) :
				  newTarget = mcHotSpot15;
				  mcGlow.x = mcHotSpot15.x;
				  mcGlow.y = mcHotSpot15.y;
				  break;
				case (yPos > row5 && yPos <= row6) :
				  newTarget = mcHotSpot18;
				  mcGlow.x = mcHotSpot18.x;
				  mcGlow.y = mcHotSpot18.y;
				  break;
				default:
				  newTarget = mcHotSpot21;
				  mcGlow.x = mcHotSpot21.x;
				  mcGlow.y = mcHotSpot21.y;
				  break;			
			 }		  
			}
		}
		private function onMouseUp(event:MouseEvent):void {
			event.currentTarget.removeEventListener(Event.ENTER_FRAME,checkHotSpot);
			event.currentTarget.stopDrag();
			var mc:MovieClip;
			mcGlow.filters=[myGlowOff];
			for (var i:int=1; i<=21; i++){
				var mcName:String = "mcHotSpot"+i;
				mc = getChildByName(mcName) as MovieClip;
				mc.mcInner.gotoAndStop(1);
			}
			event.currentTarget.x = newTarget.x;
			event.currentTarget.y = newTarget.y;
		}
		private function printJob(e:MouseEvent){
       		var myPrintJob:PrintJob = new PrintJob(); 
			var printArea:Rectangle = new  Rectangle(0, 0, 612, 792);
			if (myPrintJob.start()){  
				 try{
					 myPrintJob.addPage(this,printArea); 
				 }
				 catch (error:Error){
					trace( "Print job error"); 
				 }
			 }else{ 
    			trace( "Print job canceled"); 
			 }
			 myPrintJob.send();
			 myPrintJob = null;
		}
	}
}