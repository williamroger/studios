export class SchedulingModel {
    public id?: number;
    public date_scheduling?: string;
    public status?: number;
    public dateCancellation?: string;
    public createdAt?: string;
    public updatedAt?: string;
    public customer_id?: number;
    public comment?: string;
    public time_period_id?: number;

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
