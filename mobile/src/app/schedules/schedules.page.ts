import { SchedulesService } from './shared/schedules.service';
import { Component, OnInit } from '@angular/core';
import { ScheduleModel } from './shared/scheduleModel';
import { AlertController } from '@ionic/angular';
import { ToastController } from '@ionic/angular';

@Component({
  selector: 'app-schedules',
  templateUrl: './schedules.page.html',
  styleUrls: ['./schedules.page.scss'],
})
export class SchedulesPage implements OnInit {

  public schedules: Array<ScheduleModel>; 
  public hasSchedules: boolean;
  public schedulesMessage = '';

  public dateNow = new Date();
  public dateNowString = this.dateNow.toISOString();
  public minDatetime = `${this.dateNow.getFullYear()}-${this.dateNow.getMonth() + 1}-${(this.dateNow.getDate() < 9) ? '0' + this.dateNow.getDate() : this.dateNow.getDate()}`;

  constructor(public schedulesService: SchedulesService,
              public alert: AlertController,
              public toastr: ToastController) { }

  // tslint:disable-next-line:use-lifecycle-interface
  ngOnInit() {
    this.getSchedules();
  }

  getSchedules() {
    this.schedulesService.getSchedulesByCustomer().subscribe(
      (schedules) => {
        if (typeof schedules[0] == "object") {
          this.hasSchedules = true;
          this.schedules = schedules;
        } else {
          this.hasSchedules = false;
          this.schedulesMessage = schedules[0].toString();
        }
      }
    );
  }

  async cancelScheduling(schedule: any) {
    const sched: ScheduleModel = Object.assign(new ScheduleModel(), schedule);

    const alert = await this.alert.create({
      header: 'Confirmar',
      message: 'Deseja realmente <strong>Cancelar</strong> este agendamento?',
      buttons: [
        {
          text: 'Sim',
          cssClass: 'secondary',
          handler: async () => {
            this.schedulesService.cancelScheduling(sched).subscribe(
              (message) => {
                this.actionsForSuccess(message);
              },
              (error) => {
                if (error.error.text.indexOf('{"success":true') == 0) {
                  this.actionsForSuccess('Agendamento cancelado com sucesso!');
                } else {
                  this.actionsForError(error);
                }
              }
            );
          }
        },
        {
          text: 'Não',
          role: 'cancel'
        }
      ]
    });

    await alert.present();
  }

  async presentToast(message: string) {
    const toast = await this.toastr.create({
      message,
      duration: 2000,
      color: 'secondary'
    });
    toast.present();
  }

  actionsForSuccess(message: string) {
    this.presentToast(message);
    this.getSchedules();
  }

  actionsForError(error) {
    this.presentToast('Ocorreu um erro na aplicação, tento novamente!');
  }
}
