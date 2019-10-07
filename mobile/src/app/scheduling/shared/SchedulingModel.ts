export class SchedulingModel {
    constructor(
        public id?: number,
        public dateScheduling?: string,
        public status?: number,
        public dateCancellation?: string,
        public createdAt?: string,
        public updatedAt?: string,
        public customerId?: number,
        public comment?: string,
    ) { }

    get statusText() {
        let status = '';

        switch (this.status) {
            case 0:
                status = 'aguardando';
                break;
            case 1:
                status = 'confirmado';
                break;
            case 2:
                status = 'cancelado';
                break;
        }
        return status;
    }
}