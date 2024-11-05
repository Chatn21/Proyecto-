import { Component } from '@angular/core';
import { RouterLink, RouterLinkActive, RouterOutlet } from '@angular/router';

@Component({
  selector: 'app-casa',
  standalone: true,
  imports: [RouterOutlet,RouterLink,RouterLinkActive ],
  templateUrl: './casa.component.html',
  styleUrl: './casa.component.css'
})
export class CasaComponent {

}
