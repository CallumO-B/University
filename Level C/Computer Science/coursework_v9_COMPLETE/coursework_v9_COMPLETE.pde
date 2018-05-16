/*

** CHANGE SECOND DESIGN

*/

float colour;
int mousepress=0, start=0, total=0, score2=0, score=0, firstBarrier, secondBarrier, barrier, barrier2;
int a=0, aspeed=1, b=0, bspeed=2, c=0, cspeed=3, d=0, dspeed=4, e=0, espeed=5, f=0, fspeed=6, g=0, gspeed=7, h=0, hspeed=8, i=0, ispeed=9, j=0, jspeed=9, k=0, kspeed=10;
int aA=0, aAspeed=1, bB=0, bBspeed=2, cC=0, cCspeed=3, dD=0, dDspeed=4, eE=0, eEspeed=5, fF=0, fFspeed=6, gG=0, gGspeed=7, hH=0, hHspeed=8, iI=0, iIspeed=9, jJ=0, jJspeed=10, kK=0, kKspeed=11; //level 2

PImage img, img2, img3;

Rectangle block1 = new Rectangle(a, 640, 200);// x,y,width
Rectangle block2 = new Rectangle(b, 580, 200); 
Rectangle block3 = new Rectangle(c, 520, 200); 
Rectangle block4 = new Rectangle(d, 460, 200); 
Rectangle block5 = new Rectangle(e, 400, 200); 
Rectangle block6 = new Rectangle(f, 340, 200);
Rectangle block7 = new Rectangle(g, 280, 200);
Rectangle block8 = new Rectangle(h, 220, 200);
Rectangle block9 = new Rectangle(i, 160, 200);
Rectangle block10 = new Rectangle(j, 100, 200);
Rectangle block11 = new Rectangle(k, 40, 200);

// LEVEL 2
Rectangle block12 = new Rectangle(aA, 640, 450); 
Rectangle block13 = new Rectangle(bB, 580, 400); 
Rectangle block14 = new Rectangle(cC, 520, 350); 
Rectangle block15 = new Rectangle(dD, 460, 300); 
Rectangle block16 = new Rectangle(eE, 400, 250); 
Rectangle block17 = new Rectangle(fF, 340, 200);
Rectangle block18 = new Rectangle(gG, 280, 100);
Rectangle block19 = new Rectangle(hH, 220, 50);
Rectangle block20 = new Rectangle(iI, 160, 30);
Rectangle block21 = new Rectangle(jJ, 100, 20);
Rectangle block22 = new Rectangle(kK, 40, 5);


void setup(){
   size(560, 700);
   colorMode(HSB, 360, 360, 300);
   stroke(255);
   fill(210);  
   img =  loadImage("youwon.jpg");
   img2 = loadImage("gameover.jpg");
   img3 = loadImage("start.jpg");
}

void draw(){
  
image (img3, 0, 0); 
textSize(45);
text("Stack the blocks",130,40);
textSize(20);
text("Click the leftmouse button to stop the blocks",60,150);
textSize(20);
text("Stack the blocks to the line as neatly as possible to win",10,170);
textSize(20);
text("Press the r key , to restart the game",60,190);
textSize(35);
text("Press spacebar to start the game",0,300);

 if(start == 1){
   score2=(int)score;
   background(100); 
   line(0, 100, width, 100);
   textSize(25);
   text("Score: "+score,400,20);
   block1.display();
   block1.setColour(colour, 200, 300);
   block1.setSpeed(aspeed);      
   firstBarrier=block1.xposition()-50;
   secondBarrier=block1.xposition()+250;

    if(aspeed==0){
   block2.display();
   block2.setColour(colour, 200, 300);
      block2.setSpeed(bspeed);
    }
    if(bspeed==0){   
   block3.display();
   block3.setColour(colour, 200, 300);   
      block3.setSpeed(cspeed);
    }
     if(cspeed==0){  
   block4.display();
   block4.setColour(colour, 200, 300);    
      block4.setSpeed(dspeed);
     }
    if(dspeed==0){   
   block5.display();
   block5.setColour(colour, 200, 300); 
      block5.setSpeed(espeed);
    }
    if(espeed==0){   
   block6.display();
   block6.setColour(colour, 200, 300); 
      block6.setSpeed(fspeed);
    }
    if(fspeed==0){   
   block7.display();
   block7.setColour(colour, 200, 300); 
      block7.setSpeed(gspeed);
    }
    if(gspeed==0){   
   block8.display();
   block8.setColour(colour, 200, 300);
      block8.setSpeed(hspeed);
    }
    if(hspeed==0){   
   block9.display();
   block9.setColour(colour, 200, 300); 
      block9.setSpeed(ispeed);
    }
    if(ispeed==0){   
   block10.display();
   block10.setColour(colour, 200, 300); 
      block10.setSpeed(jspeed);
    }
    if(jspeed==0){   
   block11.display();
   block11.setColour(colour, 200, 300); 
      block11.setSpeed(kspeed);
    }   
   } 
   
   
 if(start==2){    // LEVEL 2
   image (img3, 0, 0);
   textSize(45);
   text("Stack the blocks",130,40);
   textSize(20);
   text("Click the leftmouse button to stop the blocks",60,150);
   textSize(20);
   text("Stack the block within the block below to the line as",10,170);
   text("neatly as possible to win",90,190);
   textSize(15);
   text("Press the y key , to restart the level or r to restart the game.",10,210);
   textSize(35);
   text("Press spacebar to start the game",0,300); 
 }
   if(start == 3){
     background(100); 
     line(0, 100, width, 100);
     textSize(25);
     text("Score: "+score,400,20);
    
      block12.display();
      block12.setColour(colour, 360, 300);
      block12.setSpeed2(aAspeed, barrier=block12.xposition(), barrier2=block12.xposition()+block12.blockLength());    
     
   
   if(aAspeed==0){
      block13.display();
      block13.setColour(colour, 360, 300);
      block13.setSpeed2(bBspeed, barrier=block12.xposition(), barrier2=block12.xposition()+block12.blockLength());
    }
    if(bBspeed==0){    
      block14.display();
      block14.setColour(colour, 360, 300);   
      block14.setSpeed2(cCspeed, barrier=block13.xposition(), barrier2=block13.xposition()+block13.blockLength());
    }
     if(cCspeed==0){  
      block15.display();
      block15.setColour(colour, 300, 300);    
      block15.setSpeed2(dDspeed, barrier=block14.xposition(), barrier2=block14.xposition()+block14.blockLength());

     }
    if(dDspeed==0){   
      block16.display();
      block16.setColour(colour, 300, 300); 
      block16.setSpeed2(eEspeed, barrier=block15.xposition(), barrier2=block15.xposition()+block15.blockLength());

    }
    if(eEspeed==0){   
      block17.display();
      block17.setColour(colour, 300, 300); 
      block17.setSpeed2(fFspeed, barrier=block16.xposition(), barrier2=block16.xposition()+block16.blockLength());
 
    }
    if(fFspeed==0){   
      block18.display();
      block18.setColour(colour, 200, 300); 
      block18.setSpeed2(gGspeed, barrier=block17.xposition(), barrier2=block17.xposition()+block17.blockLength());

    }
      if(gGspeed==0){   
      block19.display();
      block19.setColour(colour, 200, 300);
      block19.setSpeed2(hHspeed, barrier=block18.xposition(), barrier2=block18.xposition()+block18.blockLength());

    }
    if(hHspeed==0){   
      block20.display();
      block20.setColour(colour, 200, 300); 
      block20.setSpeed2(iIspeed, barrier=block19.xposition(), barrier2=block19.xposition()+block19.blockLength());

    }
    if(iIspeed==0){   
      block21.display();
      block21.setColour(colour, 100, 300); 
      block21.setSpeed2(jJspeed, barrier=block20.xposition(), barrier2=block20.xposition()+block20.blockLength());

    }
    if(jJspeed==0){   
      block22.display();
      block22.setColour(colour, 100, 300); 
      block22.setSpeed2(kKspeed, barrier=block21.xposition(), barrier2=block21.xposition()+block21.blockLength());

    } 
   } 
 }


void keyPressed(){                  // starts game 
  start++;
  if(key=='r') {resetGame();}
  
      if(key=='y'){ resetLevel2();}
}
void mousePressed(){               // stops blocks at mouse click and adds score 
   
   switch(mousepress){
 
      case 0:
      aspeed=0;
      score=score+10;    
      break;
      
      case 1:
      bspeed=0;
      if(firstBarrier>=block2.xposition()){
        score=score+10+(firstBarrier-block2.xposition()); 
      }
      else{
        score=score+10+(block2.xposition()-firstBarrier); 
      }
      
      break;
      
      case 2:
      cspeed=0;
      if(firstBarrier>=block3.xposition()){
        score=score+10+(firstBarrier-block3.xposition()); 
      }
      else{
        score=score+10+(block3.xposition()-firstBarrier); 
      } 
      break;
      
      case 3:
      dspeed=0;
      if(firstBarrier>=block4.xposition()){
        score=(score+10)+(firstBarrier-block4.xposition()); 
      }
      else{
        score=(score+10)+(block4.xposition()-firstBarrier); 
      } 
      break;
      
      case 4:
      espeed=0;
      if(firstBarrier>=block5.xposition()){
        score=score+10+(firstBarrier-block5.xposition()); 
      }
      else{
        score=score+10+(block5.xposition()-firstBarrier); 
      }
      break;
      
      case 5:
      fspeed=0;
      if(firstBarrier>=block6.xposition()){
        score=score+10+(firstBarrier-block6.xposition()); 
      }
      else{
        score=score+10+(block6.xposition()-firstBarrier); 
      }
      break;
      
      case 6:
      gspeed=0;
      if(firstBarrier>=block7.xposition()){
        score=score+10+(firstBarrier-block7.xposition()); 
      }
      else{
        score=score+10+(block7.xposition()-firstBarrier); 
      }
      break;
      
      case 7:
      hspeed=0;
      if(firstBarrier>=block8.xposition()){
        score=(score+10)+(firstBarrier-block8.xposition()); 
      }
      else{
        score=(score+10)+(block8.xposition()-firstBarrier); 
      } 
      break;
      
      case 8:
      ispeed=0;
      if(firstBarrier>=block9.xposition()){ 
        score=(score+10)+(firstBarrier-block9.xposition()); 
      }
      else{
        score=(score+10)+(block9.xposition()-firstBarrier); 
      }
      break;
      
      case 9:
      jspeed=0;
      if(firstBarrier>=block10.xposition()){
        score=(score+10)+(firstBarrier-block10.xposition()); 
      }
      else{
        score=(score+10)+(block10.xposition()-firstBarrier); 
      } 
      break;
      
      case 10:
      kspeed=0; 
      if(firstBarrier>=block11.xposition()){
        score=(score+10)+(firstBarrier-block11.xposition()); 
      }
      else{
        score=(score+10)+(block11.xposition()-firstBarrier); 
      } 
      break;

      case 11:
      aAspeed=0;
      if(barrier>=block1.xposition()){
        score=(score+10)+(barrier-block12.xposition()); 
      }
      else{
        score=(score+10)+(block12.xposition()-barrier); 
      }
      break;
      
      case 12:
      bBspeed=0;
      if(barrier>=block13.xposition()){
        score=(score+10)+(barrier-block13.xposition()); 
      }
      else{
        score=(score+10)+(block13.xposition()-barrier); 
      }
      break;
      
      case 13:
      cCspeed=0;
      if(barrier>=block14.xposition()){
        score=(score+10)+(barrier-block14.xposition()); 
      }
      else{
        score=(score+10)+(block14.xposition()-barrier); 
      }
      break;
      
      case 14:
      dDspeed=0;
      if(barrier>=block15.xposition()){
        score=(score+10)+(barrier-block15.xposition()); 
      }
      else{
        score=(score+10)+(block15.xposition()-barrier); 
      }
      break;
      
      case 15:
      eEspeed=0;
      if(barrier>=block16.xposition()){
        score=(score+10)+(barrier-block16.xposition()); 
      }
      else{
        score=(score+10)+(block16.xposition()-barrier); 
      }
      break;
      
      case 16:
      fFspeed=0;
      if(barrier>=block17.xposition()){
        score=(score+10)+(barrier-block17.xposition()); 
      }
      else{
        score=(score+10)+(block17.xposition()-barrier); 
      }
      break;
      
      case 17:
      gGspeed=0;
     if(barrier>=block18.xposition()){
        score=(score+10)+(barrier-block18.xposition()); 
      }
      else{
        score=(score+10)+(block18.xposition()-barrier); 
      }
      break;
      
      case 18:
      hHspeed=0;
      if(barrier>=block19.xposition()){
        score=(score+10)+(barrier-block19.xposition()); 
      }
      else{
        score=(score+10)+(block19.xposition()-barrier); 
      }
      break;
      
      case 19:
      iIspeed=0;
      if(barrier>=block20.xposition()){
        score=(score+10)+(barrier-block20.xposition()); 
      }
      else{
        score=(score+10)+(block20.xposition()-barrier); 
      }
      break;
      
      case 20:
      jJspeed=0;
      if(barrier>=block21.xposition()){
        score=(score+10)+(barrier-block21.xposition()); 
      }
      else{
        score=(score+10)+(block21.xposition()-barrier); 
      }
      break;
      
      case 21:
      kKspeed=0; 
      if(barrier>=block22.xposition()){
        score=(score+10)+(barrier-block22.xposition()); 
      }
      else{
        score=(score+10)+(block22.xposition()-barrier); 
      }
      break;      
   }
   mousepress+=1;
}

class Rectangle{                              // class for blocks 
   int xpos;
   int ypos;
   float R, G, B; 
   int bWidth;
   int bLength;
   Rectangle(int x, int y, int w){ 
      xpos=x;
      ypos=y;
      bWidth = 60;
      bLength = w;

   }
      void display(){
         fill(R,G,B); 
         rect(xpos, ypos, bLength, bWidth);
        }
        
      void setColour(float r, int u, int p){      //level2
         R = r;
         G = u;
         B = p;
         colour=colour+0.5;
         if(colour>360){
            colour=0;
         }
      }
      
       void setColour(){
         R = colour;
         G = 200;
         B = 300;
         colour=colour+0.2;
         if(colour>360){
            colour=0;
            }
         }
      void setSpeed(int speed){
         xpos+=speed;
         if(xpos>width){
            xpos=-200;
            }
         if(speed==0.0 && xpos<firstBarrier ||speed==0.0 && xpos+160 >secondBarrier){
            total= (int) score;   
            image (img2, 0, 0); 
            textSize(45);
            text("Score: " + (total),150,40); 
            
            noLoop();            
             }
          if(mousepress==11){
            total= (int) score; 
            image (img, 0, 0);             
            textSize(45);    
            text("Score: " + (total),150,40); 
            textSize(25); 
            text("Press Spacebar to continue to next level",50,100);             
             }
          }
          
       void setSpeed2(int speed, int barrier, int barrier2){     //level2
         xpos+=speed;
         if(xpos>width){
            xpos=-bLength;
         }
         
         if(speed==0.0 && xpos<barrier ||speed==0.0 && xpos+bLength>(barrier2)){
            total= (int) score;    
            image (img2, 0, 0); 
            textSize(45);
            text("Your Total Score: " + (total),10,40);
            
            noLoop();            
          }
          if(mousepress==22){             
            total= (int) score;
            image (img, 0, 0);             
            textSize(45);    
            text("Your Final Score: " + (total),10,40);  
          }
      }
      
      int xposition(){     //to manipulate
         return xpos;
      }
      int blockLength(){     //to manipulate
         return bLength;
      }
}

void resetGame(){
colour=0; mousepress=0; start=0; total=0; score2=0; score=0; firstBarrier=0; secondBarrier=0; barrier=0; barrier2=0;
a=0; aspeed=1; b=0; bspeed=2; c=0; cspeed=3; d=0; dspeed=4; e=0; espeed=5; f=0; fspeed=6; g=0; gspeed=7; h=0; hspeed=8; i=0; ispeed=9; j=0; jspeed=9; k=0; kspeed=10;
aA=0; aAspeed=1; bB=0; bBspeed=2; cC=0; cCspeed=3; dD=0; dDspeed=4; eE=0; eEspeed=5; fF=0; fFspeed=6; gG=0; gGspeed=7; hH=0; hHspeed=8; iI=0; iIspeed=9; jJ=0; jJspeed=10; kK=0; kKspeed=11; //level 2
  
}

void resetLevel2(){
colour=0; mousepress=10; start=2; /*score2=0; score=0;*/barrier=0; barrier2=0;
aA=0; aAspeed=1; bB=0; bBspeed=2; cC=0; cCspeed=3; dD=0; dDspeed=4; eE=0; eEspeed=5; fF=0; fFspeed=6; gG=0; gGspeed=7; hH=0; hHspeed=8; iI=0; iIspeed=9; jJ=0; jJspeed=10; kK=0; kKspeed=11; //level 2  
  
}