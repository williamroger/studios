export class SchedulingModel {
    public id?: number;
    public dateScheduling?: string;
    public status?: number;
    public dateCancellation?: string;
    public createdAt?: string;
    public updatedAt?: string;
    public customerId?: number;
    public comment?: string;
    public periodId?: number;

    constructor() { }

    get statusText() {
        let varStatus = '';

        switch (this.status) {
            case 0:
                varStatus = 'aguardando';
                break;
            case 1:
                varStatus = 'confirmado';
                break;
            case 2:
                varStatus = 'cancelado';
                break;
        }
        return varStatus;
    }
}
