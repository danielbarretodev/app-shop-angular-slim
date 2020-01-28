import { Component} from '@angular/core';
import {Router, ActivatedRoute, Params} from '@angular/router';

import {ProductoService} from '../services/producto.service';
import {Producto} from '../model/producto';
import {GLOBAL} from '../services/global';

@Component({
  selector: 'app-producto-add',
  templateUrl: './producto-add.component.html',
  styleUrls: ['./producto-add.component.css'],
  providers: [ProductoService]
})

export class ProductoAddComponent{
  public titulo: string;
  public producto: Producto;

  public filesToUpload;
  public  resultUpload;

  constructor(
    private _route: ActivatedRoute,
    private _router: Router,
    private _productoService: ProductoService
  ) {
    this.titulo = 'Crear un nuevo producto';
    this.producto = new Producto(0,"","",0,"");
  }

  ngOnInit() {
    console.log('Componente add produto creado');
  }

  onSubmit(){
    console.log(this.producto);

    if(this.filesToUpload.length >=1){
    this._productoService.makeFileRequest(GLOBAL.url+"upload",[],this.filesToUpload).then(
    (result) =>  {

        console.log(result);
        this.resultUpload = result;
        this.producto.imagen = this.resultUpload.filename;

        this.saveProducto();

      }, (error) => {
        console.log(error);
      }

    );
  }else {
    this.saveProducto();
  }

  }

  saveProducto(){
    this._productoService.addProducto(this.producto).subscribe(
      response => {
        if(response.code == 200){
          console.log(response.code);
          console.log(response);
          this._router.navigate(["/productos"]);
        }else{
          //console.log()
          console.log(response.code);
          console.log("holaaa");
        }
      },
      error => {
        console.log(<any>error);
      }

    );
  }


  fileChangeEvent(fileInput: any){
    this.filesToUpload = <Array<File>>fileInput.target.files;
    console.log(this.filesToUpload);
  }

}
