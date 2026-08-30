from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from schemas.chat_schema import RecommendPlanRequest, RecommendPlanResponse

app = FastAPI(title="AVI AI Microservice", version="1.0.0")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.get("/health")
def health_check():
    return {"status": "healthy", "service": "avi-ai-microservice"}

@app.post("/recommend-plan", response_model=RecommendPlanResponse)
def recommend_plan(req: RecommendPlanRequest):
    # Reglas y orquestación inteligente de planes
    if req.age_months < 12:
        plan = "Plan Cachorros / Gatitos Primer Año"
        rationale = "Esquema completo de primovacunación, desparasitación seriada y consultas de crecimiento."
    elif req.age_months > 84:
        plan = "Plan Senior Patitas Doradas"
        rationale = "Monitoreo geriátrico, perfil renal/hepático semestral y profilaxis dental preventiva."
    else:
        plan = "Plan Patitas Vital"
        rationale = "Cobertura balanceada de vacunas anuales, consultas ilimitadas y descuentos en urgencias."

    return RecommendPlanResponse(
        recommended_plan=plan,
        confidence=0.95,
        rationale=rationale,
        is_fallback=False
    )
