import { Component} from '@angular/core';

@Component({
  selector: 'home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent{

  public titulo:string;
  constructor() {
    this.titulo = 'Home'
  }

  ngOnInit() {
    console.log('se ha cargado home.')
  }

}
