import {Injectable} from '@angular/core';
import { HttpClient, HttpHeaders} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Producto} from '../model/producto';
import {GLOBAL} from './global';

@Injectable()
export class ProductoService{
  public  url: string;

  constructor(
    public http: HttpClient
  ){
    this.url = GLOBAL.url;
  }

  getProductos(): Observable<any>{
      return this.http.get(this.url+"productos");
  }


  addProducto(producto: Producto): Observable<any>{

    let json = JSON.stringify(producto);
    let params = "json="+json;
  //  console.log(params);
    let headers = new HttpHeaders().set("Content-Type","application/x-www-form-urlencoded");
    return this.http.post(this.url+"productos", params, {headers:headers});

  }

  makeFileRequest(url: string, params: Array<string>, files: Array<File>){
    return new Promise((resolve, reject) => {
      var formData: any = new FormData();
      var xhr = new XMLHttpRequest();

      for(var i=0;i < files.length;i++){
        formData.append("uploads",files[i], files[i].name);
      }

      xhr.onreadystatechange = function(){
        if(xhr.readyState == 4){
          if(xhr.status == 200){
            resolve(JSON.parse(xhr.response));
          }else{
            reject(xhr.response);
          }
        }
      };

      xhr.open("POST",url, true);
      xhr.send(formData);



    });
  }

}
