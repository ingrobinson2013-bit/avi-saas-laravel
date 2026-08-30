from pydantic import BaseModel, Field
from typing import List, Optional

class RecommendPlanRequest(BaseModel):
    species: str = Field(..., example="dog")
    age_months: int = Field(..., example=24)
    health_conditions: Optional[List[str]] = Field(default_factory=list)
    budget_tier: Optional[str] = Field(default="medium")

class RecommendPlanResponse(BaseModel):
    recommended_plan: str
    confidence: float
    rationale: str
    is_fallback: bool = False
