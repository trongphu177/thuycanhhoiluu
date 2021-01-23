#include "WiFi.h"
#include <HTTPClient.h>
#include "ESP32TimerInterrupt.h"
#include <DHT.h>
#include <DHT_U.h>
const int DHTPIN = 27; //Đọc dữ liệu từ DHT22 ở chân 27 trên mạch Arduino
const int DHTTYPE = DHT11; //Khai báo loại cảm biến, có 2 loại là DHT11 và DHT22
const char* ssid = "CA HCM";
const char* password = "hungcuong90";
#define pin_rain 39
#define pin_light 36
#define pin_pH 34
#define up_pH 18
#define down_pH 19
#define lamp 23
#define up_TDS 5
#define vent 13
#define dew 14
#define shield1 17
#define shield2 27
#define RXD2 16
#define TXD2 4
#define pin_led 2
int i,n,buf[10],tem,stt_giam_nhiet,stt_tang_nhiet,stt_giam_am,stt_tang_am,stt_giam_as,stt_tang_as,stt_giam_pH,stt_tang_pH,stt_giam_TDS,stt_tang_TDS;
float Tmax,Tmin,Hmax,Hmin,Lmax,Lmin,Pmax,Pmin,Smax,Smin,tds,vl_rain,vl_light,vl_pH, temp, hum,value_sensor;
String chuoi = "11111111";
char chuoi1[8];
ESP32Timer ITimer0(0);
#define TIMER0_INTERVAL_MS        5000
void IRAM_ATTR TimerHandler0(void)
{ 
  //static bool toggle0 = false;
  #if (TIMER_INTERRUPT_DEBUG > 0)
  #endif
  digitalWrite(pin_led, LOW);
  digitalWrite(shield1, 1);
  digitalWrite(shield2, 1);
  ITimer0.stopTimer();
}
DHT dht(DHTPIN, DHTTYPE);
void setup(){ 
    pinMode(pin_rain,INPUT);
    pinMode(pin_light,INPUT);
    pinMode(pin_pH,INPUT);  
    pinMode(lamp,OUTPUT);
    pinMode(up_pH,OUTPUT);
    pinMode(down_pH,OUTPUT);
    pinMode(up_TDS,OUTPUT);
    pinMode(shield1,OUTPUT);
    pinMode(shield2,OUTPUT);
    pinMode(dew,OUTPUT);
    pinMode(vent,OUTPUT);
    Serial.begin(9600);
    Serial2.begin(9600, SERIAL_8N1, RXD2, TXD2);//RX2 = IO16, TX2 = IO4 
    dht.begin(); // Khởi động cảm biến DHT11
    WiFi.begin(ssid, password);
    while (WiFi.status() != WL_CONNECTED){
                delay(500);
                Serial.print(".");
              }
      Serial.println();
      Serial.print("Connected,");
    
}

void loop(){   
        n = 30;
        while(n>0){
         n--;
         Control_device();
		 Send_Status();
         delay(50);

          }
        Send_value_sensor();
 
          }
void Send_value_sensor(){
          tds = read_tds();                      //Giá trị tds
          vl_rain = read_analog(pin_rain);       //Giá trị cảm biến mưa
          vl_light = read_analog(pin_light);     //Giá trị cảm biến ánh sáng
          vl_pH = read_analog(pin_pH);           //Giá trị cảm biến ánh sáng
          temp = dht.readTemperature();          //Giá trị nhiệt độ
          hum = dht.readHumidity();              //Giá trị độ ẩm
          String Link = "http://thuycanhhoiluu.chaugotronglan.com/conf/sensor.php?temp="+(String)temp+"&hum="+(String)hum;
          Link = Link +"&tds="+(String)tds +"&light="+(String)vl_light+"&rain="+(String)vl_rain+"ph="+(String)vl_pH;
          HTTPClient http;
          http.begin(Link);
          int code = http.GET();
          delay(50);
          http.end();
    }
void Control_device(){
          HTTPClient http;
          http.begin("http://thuycanhhoiluu.chaugotronglan.com/device/ajax/get_status.php");
          int code = http.GET();
          if (code > 0) {
              chuoi = http.getString();
              if (chuoi.charAt(0)=='0') set_auto();
              else set_tay();
           http.end();
        }}
void Send_Status(){
              HTTPClient Request;
              String Link = "http://thuycanhhoiluu.chaugotronglan.com/device/ajax/set_status.php?";
              for (i = 1;i<7;i++){
                     char c = chuoi1[i];
                     Link += "pin_" + (String)i +"=" + (String)c;
                     }
              Request.begin(Link);
              Request.GET();
              Request.end();
              }
float read_analog(int sensorpin){
                      for(int i=0;i<10;i++){       // doc 10 gia tri cua sensor 
                          buf[i]=analogRead(sensorpin);
                          delay(10);}
                      for(int i=0;i<9;i++){        //sắp xêp theo thứ tự từ bé đên lon
                          for(int j=i+1;j<10;j++){
                            if(buf[i]>buf[j]){
                              tem=buf[i];
                              buf[i]=buf[j];
                              buf[j]=tem;
                            }
                          }
                     }
                     int value_total = 0;
                     for(int i=3;i<7;i++)                    //take the average value of 6 center sample
                      value_total+=buf[i];
                    float avgValue=(float)value_total*5.0/1024/4; //convert the analog into millivolt
                    switch (sensorpin) {
                          case 39:
                                avgValue = (float)value_total/16;
                                Serial.print("avgValue = ");
                                Serial.println(avgValue);
                                if(avgValue<500) value_sensor = 0;
                                else value_sensor = 1;
                                break;
                           case 36:
                                avgValue = (float)value_total/163.8;
                                value_sensor = avgValue;
                                break;
                           case 34:
                                avgValue=(float)value_total*5.0/1024/16;
                                Serial.print("avgValue = ");
                                Serial.println(avgValue);
                                value_sensor=avgValue*3;
                                break;  
                }}

void set_auto(){
              get_vl();
                   if(vl_light < Lmin || chuoi1[3] == '0') stt_giam_nhiet = solution_down(6, temp, Tmin, Tmax);
                   if(temp > Tmax || stt_giam_nhiet == 1) stt_giam_nhiet = solution_down(6, temp, Tmin, Tmax);
                        else if(temp<Tmin||stt_tang_nhiet == 1) stt_tang_nhiet = solution_up(5, temp, Tmin, Tmax);
                   if(hum > Hmax || stt_giam_am == 1) stt_giam_am = solution_down(vent, hum, Hmin, Hmax);
                        else if(hum < Hmin || stt_tang_am == 1) stt_tang_am = solution_up(6, hum, Hmin, Hmax);
                   if(vl_pH > Pmax || stt_giam_pH == 1) stt_giam_pH = solution_down(1, vl_pH, Pmin, Pmax);
                        else if(vl_pH < Pmin || stt_tang_pH == 1) stt_tang_am = solution_up(2, vl_pH, Pmin, Pmax);
                   if(tds < Smin || stt_tang_TDS == 1) stt_tang_TDS = solution_up(4, tds, Smin, Smax);
                   if (vl_rain == 1 || vl_light >= Lmax || temp >= Tmax) update_device(7,'0');
                        else if (vl_rain == 0 && vl_light < Lmax && temp < Tmax) update_device(7,'1');
              }
void set_tay(){
                  if(chuoi != chuoi1){
                    for( i=1;i<8;i++){
                      if(chuoi.charAt(i) != chuoi1[i]) update_device(i,chuoi.charAt(i));     
                      }
                    }
}
int solution_down(int device, float vl,float vl_min, float vl_max){
                  update_device(device,'0');
                
                  float vl_average = (vl_min + vl_max)/2;
                  if (vl <= vl_average) {
                    update_device(device,'1');
                    return 0;
                    }
                  return 1;
                    }
int solution_up(int device, float vl,float vl_min, float vl_max){
                          update_device(device,'1');
                          float vl_average = (vl_min+vl_max)/2;
                          if (vl >= vl_average) {
                            update_device(device,'0');
                              return 0;
                            }
                          return 1;
                          }


void update_device(int thu_tu, char trang_thai){
                    switch (thu_tu){
                        case 1: { set_device(down_pH, trang_thai);    
                                   break;}
                        case 2: {set_device(up_pH,trang_thai );
                                   break;}
                        case 3: {set_device(lamp,trang_thai);
                                  break;}
                        case 4: {set_device(up_TDS,trang_thai);
                                  break;}
                        case 5: { set_device(vent,trang_thai);
                                  break;}
                        case 6: { set_device(dew,trang_thai);
                                  break;}                            
                        case 7: { shield(trang_thai);
                                  break;}}
                      chuoi1[thu_tu] = trang_thai;         
                  }
void set_device(int device, char stt){
        if (stt == '1') digitalWrite(device, 1);
        else digitalWrite(device, 0);
}
void get_vl(){
  int lenght = chuoi.length();
    for(i=1;i<=lenght;i++){
          //char a = chuoi.charAt(i);
          switch (chuoi.charAt(i)){      
            case 'T':
                  i++;
                  Tmin = vl();
                  i++;
                  Tmax = vl();
                  i--;
                  break;
            case 'H':
                  i++;
                  Hmin = vl();
                  i++;
                  Hmax = vl();
                  i--;
                  break; 
            case 'L':
                  i++;
                  Lmin = vl();
                  i++;
                  Lmax = vl();
                  i--;
                  break; 
            case 'S':
                  i++;
                  Smin = vl();
                  i++;
                  Smax = vl();
                  i--;
                  break; 
            case 'P':
                  i++;
                  Pmin = vl();
                  i++;
                  Pmax = vl();
                  break;                                           
                  }
          }
}
float read_tds(){
            String value = "";  
            Serial2.println("AT+VALUE=?");
            delay(50);
            while (Serial2.available() != 0) value = value + char(Serial2.read());
            int value_uart1 = value.toInt();
            float value_uart = (float)value_uart1;
            return value_uart;
            }
void shield(char trang_thai){
              digitalWrite(pin_led, HIGH);
              if(trang_thai == '0' && chuoi1[7] == '1') digitalWrite(shield2, 0);
              if(trang_thai == '1' && chuoi1[7] == '0') digitalWrite(shield1, 0);
              ITimer0.restartTimer();
        }           
float vl(){
                      String vl_string ="";
                      int vl_int;
                      float vl_float;
                     while ('0'<=chuoi.charAt(i)&&chuoi.charAt(i)<='9')
                     {
                         vl_string = vl_string + chuoi.charAt(i);
                        i++;
                        }
                      if(chuoi.charAt(i)=='.') {
                          i++;
                           vl_string = vl_string + chuoi.charAt(i);
                           while('0'<=chuoi.charAt(i)&&chuoi.charAt(i)<='9')i++; 
                           vl_int = vl_string.toInt();
                           vl_float = (float)vl_int/10;                    
                           return vl_float;
                         }
                          vl_int = vl_string.toInt();
                           vl_float = (float)vl_int;                           
                           return vl_float;                         
                           }
