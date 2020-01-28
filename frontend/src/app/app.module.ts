import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';


//Rutas
import {routing, appRoutingProviders} from './app.routing';

//Componentes
import { AppComponent } from './app.component';
import { HomeComponent } from './home/home.component';
import { ErrorComponent } from './error/error.component';
import { ProductosListComponent } from './productos-list/productos-list.component';
import { HttpClientModule} from '@angular/common/http';
import { ProductoAddComponent } from './producto-add/producto-add.component';


@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    ErrorComponent,
    ProductosListComponent,
    ProductoAddComponent
  ],
  imports: [
    BrowserModule,
    routing,
    HttpClientModule,
    FormsModule
  ],
  providers: [
    appRoutingProviders
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
