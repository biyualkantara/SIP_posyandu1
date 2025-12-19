import AuthController from './AuthController'
import ProfileController from './ProfileController'
import BayiController from './BayiController'
import DuspyController from './DuspyController'
import KehadiranKaderController from './KehadiranKaderController'
import Posyandu from './Posyandu'
import RekapitulasiController from './RekapitulasiController'
import OperatorController from './OperatorController'
import SipintarChatbotController from './SipintarChatbotController'
import SipintarStuntingController from './SipintarStuntingController'
import AiStuntingPredictController from './AiStuntingPredictController'

const Controllers = {
    AuthController: Object.assign(AuthController, AuthController),
    ProfileController: Object.assign(ProfileController, ProfileController),
    BayiController: Object.assign(BayiController, BayiController),
    DuspyController: Object.assign(DuspyController, DuspyController),
    KehadiranKaderController: Object.assign(KehadiranKaderController, KehadiranKaderController),
    Posyandu: Object.assign(Posyandu, Posyandu),
    RekapitulasiController: Object.assign(RekapitulasiController, RekapitulasiController),
    OperatorController: Object.assign(OperatorController, OperatorController),
    SipintarChatbotController: Object.assign(SipintarChatbotController, SipintarChatbotController),
    SipintarStuntingController: Object.assign(SipintarStuntingController, SipintarStuntingController),
    AiStuntingPredictController: Object.assign(AiStuntingPredictController, AiStuntingPredictController),
}

export default Controllers